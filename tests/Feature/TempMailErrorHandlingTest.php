<?php

namespace Tests\Feature;

use App\Http\Controllers\TempMailController;
use App\Models\Statistic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Regression tests for temp-mail error handling:
 *  - a cache write failure must not blank the inbox, and
 *  - IMAP/cache failures must never leak paths or stack traces to clients.
 */
class TempMailErrorHandlingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Safety guard: never against the live MySQL DB.
        if (config('database.default') !== 'sqlite' || config('database.connections.sqlite.database') !== ':memory:') {
            $this->fail('Tests are NOT using sqlite :memory:. Refusing to run against the live database.');
        }
    }

    public function test_message_is_returned_even_when_the_cache_write_fails(): void
    {
        $controller = new class extends TempMailController {
            public function buildMessage($message)
            {
                return $this->formatMessage($message, 'example', 'someone');
            }

            protected function extractMessageData($message, $hash_id, $domainPrefix, $prefix, $client = null, $seenFlag = false)
            {
                return ['id' => $hash_id, 'subject' => 'Hello'];
            }
        };

        $message = new class {
            public function getAttributes(): array
            {
                return ['uid' => 98765];
            }
        };

        // Simulate the production failure: the file cache cannot write.
        Cache::shouldReceive('remember')
            ->once()
            ->andThrow(new \RuntimeException('file_put_contents(): Failed to open stream'));

        $data = $controller->buildMessage($message);

        $this->assertSame(Hashids::encode(98765), $data['id']);
        $this->assertSame('Hello', $data['subject']);

        // Message still counted even though it could not be cached.
        $this->assertTrue(
            Statistic::where('key', 'messages')->where('value', $data['id'])->exists()
        );
    }

    public function test_imap_failure_does_not_leak_paths_or_traces(): void
    {
        $controller = new class extends TempMailController {
            public function connection()
            {
                throw new \RuntimeException('IMAP login failed at /home/autolikerlive/laravel/secret.php');
            }
        };

        $result = $controller->allMessages(new Request(['email' => 'someone@example.com']));

        $this->assertFalse($result['status']);
        $this->assertArrayNotHasKey('trace', $result);
        $this->assertArrayNotHasKey('file', $result);
        $this->assertArrayNotHasKey('line', $result);
        $this->assertStringNotContainsString('secret.php', json_encode($result));
        $this->assertStringNotContainsString('RuntimeException', json_encode($result));
    }
}
