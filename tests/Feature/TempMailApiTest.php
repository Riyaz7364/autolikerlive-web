<?php

namespace Tests\Feature;

use App\Events\InboxMessageReceived;
use App\Models\TempInbox;
use App\Models\Tempmail;
use Database\Seeders\TestFixturesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Temp Mail API (app-facing). Hermetic: sqlite :memory:, no Firebase, no
 * Reverb, no IMAP network calls. Covers authentication (app-only), inbox
 * ownership (inbox_token), and websocket channel authorization.
 */
class TempMailApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Safety guard: never against the live MySQL DB.
        if (config('database.default') !== 'sqlite' || config('database.connections.sqlite.database') !== ':memory:') {
            $this->fail('Tests are NOT using sqlite :memory:. Refusing to run against the live database.');
        }

        $this->seed(TestFixturesSeeder::class);
    }

    /* ---------------- app-only access (App Check) ---------------- */

    public function test_endpoints_require_app_check_token(): void
    {
        // Enforce ON for these requests.
        config(['services.firebase.appcheck_enforce' => true]);

        foreach (['create', 'get-mail', 'message', 'delete', 'broadcasting/auth'] as $action) {
            $response = $this->postJson("/api/tempmail/{$action}");
            $this->assertContains($response->status(), [401],
                "POST tempmail/{$action} without X-Firebase-AppCheck must be 401.");
        }
    }

    public function test_endpoints_reject_fake_app_check_token(): void
    {
        config(['services.firebase.appcheck_enforce' => true]);

        $this->postJson('/api/tempmail/create', [], [
            'X-Firebase-AppCheck' => 'obviously-fake-token',
        ])->assertStatus(403);
    }

    /* ---------------- creating inboxes ---------------- */

    public function test_app_can_create_inbox(): void
    {
        $res = $this->postJson('/api/tempmail/create')->assertStatus(201);

        $this->assertTrue($res->json('success'));
        $this->assertStringContainsString('@', $res->json('data.email'));
        $this->assertNotEmpty($res->json('data.inbox_token'));
        $this->assertSame('inbox.message', $res->json('data.websocket.event'));
        $this->assertSame(
            'inbox.'.$res->json('data.inbox_token'),
            $res->json('data.websocket.channel')
        );

        $inbox = TempInbox::where('email', $res->json('data.email'))->firstOrFail();
        $this->assertTrue($inbox->isActive());
    }

    public function test_custom_local_part_and_domain_are_respected(): void
    {
        try {
            $domain = Tempmail::where('status', 1)->firstOrFail()->name;
        } catch (\Throwable $e) {
            $this->markTestSkipped('No tempmail domains seeded.');
        }

        $res = $this->postJson('/api/tempmail/create', [
            'local_part' => 'my.own.name',
            'domain' => $domain,
        ], ['X-Firebase-AppCheck' => 'test-token']);

        $res->assertStatus(201);
        $this->assertSame('my.own.name@'.$domain, $res->json('data.email'));
    }

    public function test_invalid_local_part_rejected(): void
    {
        $this->postJson('/api/tempmail/create', ['local_part' => 'no spaces allowed'])
            ->assertStatus(422);
    }

    public function test_unknown_domain_rejected(): void
    {
        $this->postJson('/api/tempmail/create', ['domain' => 'not-ours.example.com'])
            ->assertStatus(422);
    }

    public function test_duplicate_address_conflicts(): void
    {
        $first = $this->postJson('/api/tempmail/create', ['local_part' => 'dup.test'])
            ->assertStatus(201);

        $this->postJson('/api/tempmail/create', ['local_part' => 'dup.test'])
            ->assertStatus(409);
    }

    /* ---------------- ownership (inbox_token) ---------------- */

    public function test_get_mail_requires_opened_inbox_token(): void
    {
        $created = $this->postJson('/api/tempmail/create')->json('data');
        $inbox = TempInbox::where('inbox_token', $created['inbox_token'])->firstOrFail();

        // Wrong token — 404, as if the mailbox does not exist.
        $this->postJson('/api/tempmail/get-mail', ['email' => $inbox->email, 'inbox_token' => 'nope-nope-nope'])
            ->assertStatus(404);

        // Right token — endpoint runs (IMAP may be offline in CI, but never 404).
        $response = $this->postJson('/api/tempmail/get-mail', ['email' => $inbox->email, 'inbox_token' => $created['inbox_token']]);
        $response->assertStatus(200)->assertJson(['success' => true]);
    }

    public function test_message_and_delete_require_ownership(): void
    {
        $created = $this->postJson('/api/tempmail/create')->json('data');
        $inbox = TempInbox::where('inbox_token', $created['inbox_token'])->firstOrFail();

        $this->postJson('/api/tempmail/message', ['email' => $inbox->email, 'inbox_token' => 'wrong', 'id' => 'x'])
            ->assertStatus(404);

        $this->postJson('/api/tempmail/delete', ['email' => $inbox->email, 'inbox_token' => 'wrong'])
            ->assertStatus(404);
    }

    public function test_delete_removes_inbox_and_kills_channel(): void
    {
        $created = $this->postJson('/api/tempmail/create')->json('data');

        $this->postJson('/api/tempmail/delete', [
            'email' => $created['email'],
            'inbox_token' => $created['inbox_token'],
        ])->assertOk()->assertJson(['success' => true]);

        $this->assertDatabaseMissing('temp_inboxes', ['inbox_token' => $created['inbox_token']]);
    }

    /* ---------------- websocket channel authorization ---------------- */

    public function test_broadcast_auth_allows_live_inbox_and_rejects_dead(): void
    {
        $created = $this->postJson('/api/tempmail/create')->json('data');
        $token = $created['inbox_token'];

        $channel = 'private-inbox.'.$token;

        $payload = ['socket_id' => '111.222', 'channel_name' => $channel];

        $res = $this->postJson('/api/tempmail/broadcasting/auth', $payload)
            ->assertOk();

        $auth = $res->json();
        $this->assertArrayHasKey('auth', $auth);

        // A dead/unknown inbox token must not be authorized.
        $this->postJson('/api/tempmail/broadcasting/auth', [
            'socket_id' => '111.222',
            'channel_name' => 'private-inbox.dead-inbox-token',
        ])->assertStatus(403);
    }

    /* ---------------- expiry ---------------- */

    public function test_expired_inbox_is_not_readable(): void
    {
        $created = $this->postJson('/api/tempmail/create', ['ttl_minutes' => 5])->json('data');
        $inbox = TempInbox::where('inbox_token', $created['inbox_token'])->firstOrFail();
        $inbox->update(['expires_at' => now()->subMinute()]);

        $this->postJson('/api/tempmail/get-mail', ['email' => $created['email'], 'inbox_token' => $created['inbox_token']])
            ->assertStatus(404);
    }
}
