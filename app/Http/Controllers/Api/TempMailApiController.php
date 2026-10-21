<?php

namespace App\Http\Controllers\Api;

use App\Events\InboxMessageReceived;
use App\Http\Controllers\TempMailController;
use App\Models\Profile;
use App\Models\TempInbox;
use App\Models\Tempmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

/**
 * Temp Mail API — only reachable by our own app: every route in this group
 * passes AppCheckMiddleware (X-Firebase-AppCheck verified against OUR
 * Firebase project).
 *
 * Inbox ownership is additionally scoped by inbox_token: the token is issued
 * once by POST /tempmail/create and must accompany every read/delete, so a
 * verified app can still not read mailboxes it did not create.
 */
class TempMailApiController extends \Illuminate\Routing\Controller
{
    public function __construct(protected TempMailController $webmailer) {}

    /**
     * POST /api/tempmail/create
     * body: { local_part?, domain?, ttl_minutes? }
     *
     * Allocates a new temp inbox. The inbox_token in the response is the
     * ONLY key to the mailbox — store it in the app.
     * {:email, :inbox_token, :expires_at, :websocket(channel|event|auth_url)}
     */
    public function create(Request $request): JsonResponse
    {
        $domains = Tempmail::where('status', 1)->pluck('name')->all();

        if (empty($domains)) {
            return response()->json(['success' => false, 'message' => 'No temp-mail domains configured.'], 503);
        }

        $data = $request->validate([
            'local_part' => ['sometimes', 'nullable', 'string'],
            'domain' => ['sometimes', 'nullable', 'in:'.implode(',', $domains)],
            'ttl_minutes' => ['sometimes', 'nullable', 'integer', 'min:5', 'max:'.config('tempmail-api.max_ttl_minutes')],
        ]);

        if (isset($data['local_part'])) {
            $localPart = strtolower($data['local_part']);
            if (! preg_match('/^[a-z0-9]([a-z0-9._-]{1,28})[a-z0-9]$/', $localPart)) {
                return response()->json(['success' => false, 'message' => 'local_part must be 3-30 chars [a-z0-9._-]].'], 422);
            }
        } else {
            // Same generator as the web flow: random Profile name + random suffix.
            $randomName = '';

            try {
                $profile = Profile::inRandomOrder()->first();
                if ($profile) {
                    $randomName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $profile->name));
                }
            } catch (\Throwable $e) {
                report($e); // profiles table unavailable — fall back to random
            }

            if ($randomName === '') {
                $randomName = strtolower(quickRandom(5));
            }
            $localPart = $randomName.'.'.strtolower(quickRandom(5));
        }

        $domain = $data['domain'] ?? $domains[array_rand($domains)];
        $email = $localPart.'@'.$domain;

        if (TempInbox::where('email', $email)->exists()) {
            return response()->json(['success' => false, 'message' => 'Address already in use.'], 409);
        }

        $ttl = $data['ttl_minutes'] ?? config('tempmail-api.ttl_minutes');

        $inbox = TempInbox::create([
            'inbox_token' => bin2hex(random_bytes(20)),
            'email' => $email,
            'local_part' => $localPart,
            'domain' => $domain,
            'expires_at' => now()->addMinutes($ttl),
            'last_seen_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'email' => $inbox->email,
                'inbox_token' => $inbox->inbox_token,
                'expires_at' => $inbox->expires_at->toIso8601String(),
                'websocket' => [
                    'channel' => $inbox->channel(),
                    'event' => 'inbox.message',
                    'auth_url' => url('/api/tempmail/broadcasting/auth'),
                ],
            ],
        ], 201);
    }

    /**
     * POST /api/tempmail/get-mail
     * body: { email, inbox_token }
     *
     * Lists all messages of the inbox (parses IMAP, caches formatted
     * messages) and pushes any newly seen message over WebSocket.
     */
    public function getMail(Request $request): JsonResponse
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => 'required|email',
            'inbox_token' => ['required', 'string', function ($attribute, $value, $fail) {
                // ownership check done below — just reject trivial junk early
                if (strlen($value) < 10) {
                    $fail('Invalid inbox_token.');
                }
            }],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        $inbox = $this->ownedInbox($request->input('email'), $request->input('inbox_token'));
        if (! $inbox) {
            return response()->json(['success' => false, 'message' => 'Inbox not found or token mismatch.'], 404);
        }

        $inbox->touchActivity();

        $result = $this->webmailer->allMessages(new Request(['email' => $inbox->email]));

        // Detect NEW messages (uids not seen before) and push them out.
        try {
            $this->broadcastNew($inbox, $result);
        } catch (\Throwable $e) {
            report($e); // never break the fetch because the WS push failed
        }

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }

    /**
     * POST /api/tempmail/message
     * body: { email, inbox_token, id }   (id = hash id from get-mail/WebSocket)
     *
     * Full message body (marks the IMAP message as read).
     */
    public function message(Request $request): JsonResponse
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => 'required|email',
            'inbox_token' => 'required|string',
            'id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        $inbox = $this->ownedInbox($request->input('email'), $request->input('inbox_token'));
        if (! $inbox) {
            return response()->json(['success' => false, 'message' => 'Inbox not found or token mismatch.'], 404);
        }

        $inbox->touchActivity();

        $message = $this->webmailer->getMessage(new Request(['id' => $request->input('id')]));

        // getMessage never throws; it returns a friendly error array.
        if (is_array($message) && str_contains((string) ($message['subject'] ?? ''), 'no longer exists')) {
            return response()->json(['success' => false, 'message' => 'Message no longer available.'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $message,
        ]);
    }

    /**
     * POST /api/tempmail/delete
     * body: { email, inbox_token }
     *
     * Removes the inbox (and its websocket channel). IMAP copies disappear
     * on the server according to the mail server retention policy.
     */
    public function delete(Request $request): JsonResponse
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => 'required|email',
            'inbox_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        $inbox = $this->ownedInbox($request->input('email'), $request->input('inbox_token'));
        if (! $inbox) {
            return response()->json(['success' => false, 'message' => 'Inbox not found or token mismatch.'], 404);
        }

        Cache::forget('tempinbox:'.$inbox->uuid.':uids');
        $inbox->delete();

        return response()->json(['success' => true]);
    }

    /**
     * POST /api/tempmail/broadcasting/auth
     *
     * WebSocket private-channel authorization (Pusher protocol signature).
     * The client sends { socket_id, channel_name } plus X-Firebase-AppCheck;
     * the channel is authorized because the inbox token embedded in the
     * channel name still points at a live inbox (ownership proof) and the
     * request passed App Check (this-app proof).
     */
    public function broadcastAuth(Request $request): JsonResponse
    {
        $request->validate([
            'socket_id' => 'required|string',
            'channel_name' => ['required', 'string', 'starts_with:private-inbox.'],
        ]);

        if (strpos($request->input('channel_name'), 'inbox.') === false) {
            abort(422, 'Only temp-mail inbox channels are allowed.');
        }

        $token = Str::after($request->input('channel_name'), 'private-inbox.');
        $inbox = TempInbox::where('inbox_token', $token)->first();

        abort_if(! $inbox || ! $inbox->isActive(), 403, 'Unknown or expired inbox.');

        $connection = config('broadcasting.connections.reverb');

        $key = $connection['key'] ?? null;
        $secret = $connection['secret'] ?? null;

        abort_if(! $key || ! $secret, 503, 'WebSocket server is not configured.');

        $signature = hash_hmac(
            'sha256',
            $request->input('socket_id').':'.$request->input('channel_name'),
            $secret
        );

        return response()->json([
            'auth' => $key.':'.$signature,
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Resolve the inbox, enforcing ownership + TTL.
     */
    protected function ownedInbox(string $email, string $token): ?TempInbox
    {
        if (config('tempmail-api.allow_unowned_access')) {
            // Legacy mode: any app-check-verified caller can read any mailbox.
            $inbox = TempInbox::where('email', $email)->first();

            return ($inbox && $inbox->isActive()) ? $inbox : null;
        }

        $inbox = TempInbox::where('email', $email)
            ->where('inbox_token', $token)
            ->first();

        return ($inbox && $inbox->isActive()) ? $inbox : null;
    }

    /**
     * Compare fetched message ids against the cache; broadcast the unseen
     * ones and remember them (last 200 ids per inbox).
     */
    protected function broadcastNew(TempInbox $inbox, $fetchResult): void
    {
        $key = 'tempinbox:'.$inbox->uuid.':uids';

        $messages = $fetchResult['messages'] ?? [];

        if (! is_array($messages) || ! ($fetchResult['status'] ?? false)) {
            return; // IMAP hiccup — do not broadcast garbage
        }

        $known = array_flip(Cache::get($key, []));

        $messages = array_reverse($messages); // oldest first for stable ordering

        $newIds = [];
        foreach ($messages as $msg) {
            $id = $msg['id'] ?? null;

            if (! $id || isset($known[$id])) {
                continue;
            }

            InboxMessageReceived::dispatch($inbox, $msg);
            $newIds[] = $id;
        }

        if (count($newIds) > 0) {
            $all = array_values(array_merge(array_keys($known), $newIds));

            if (count($all) > 200) {
                $all = array_slice($all, -200);
            }

            Cache::put($key, $all, now()->addHours(48));
        } elseif (count($known) > 0) {
            Cache::put($key, array_keys($known), now()->addHours(48));
        }
    }
}
