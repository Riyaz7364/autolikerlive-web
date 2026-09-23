<?php

namespace App\Http\Controllers;

use App\Models\ChatBlock;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class ChatController extends Controller
{
    /**
     * Start (or resume) a guest conversation.
     * Captures full visitor info: IP, UA, browser, platform, device, page, geo.
     */
    public function start(Request $request)
    {
        if (!config('chat.enabled')) {
            return response()->json(['ok' => false, 'message' => 'Chat disabled'], 503);
        }

        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'nullable|email|max:190',
            'page_url' => 'nullable|string|max:500',
            'message' => 'nullable|string|max:2000',
        ]);

        // Blocked IP / token check
        $ip = $request->ip();
        if ($this->isBlocked($ip, null)) {
            return response()->json(['ok' => false, 'message' => 'You have been blocked from chat.'], 403);
        }

        $agent = new Agent();
        $agent->setUserAgent($request->userAgent() ?? '');

        $device = $agent->isMobile() ? 'mobile' : ($agent->isTablet() ? 'tablet' : 'desktop');

        $geo = $this->geoLookup($ip);

        $conv = ChatConversation::create([
            'uuid' => (string) Str::uuid(),
            'guest_token' => Str::random(64),
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'page_url' => $data['page_url'] ?? substr($request->headers->get('referer', ''), 0, 500),
            'referrer' => substr($request->headers->get('referer', ''), 0, 500),
            'ip' => $ip,
            'country' => $geo['country'] ?? null,
            'city' => $geo['city'] ?? null,
            'user_agent' => substr($request->userAgent() ?? '', 0, 2000),
            'browser' => $agent->browser() ?: null,
            'browser_version' => $agent->version($agent->browser()) ?: null,
            'platform' => $agent->platform() ?: null,
            'device' => $device,
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        $messages = [];
        if (!empty($data['message'])) {
            $msg = $conv->messages()->create([
                'sender' => 'guest',
                'body' => $data['message'],
                'ip' => $ip,
            ]);
            $conv->increment('admin_unread');
            $conv->update(['last_message_at' => now()]);
            $messages[] = $this->formatMsg($msg);
            $this->publishToNode($conv, $msg);
        }

        return response()->json([
            'ok' => true,
            'uuid' => $conv->uuid,
            'token' => $conv->guest_token,
            'admin_online' => $this->adminOnline(),
            'messages' => $messages,
        ]);
    }

    /** Guest sends a message (HTTP — source of truth). Node only relays. */
    public function send(Request $request)
    {
        if (!config('chat.enabled')) {
            return response()->json(['ok' => false], 503);
        }

        $data = $request->validate([
            'uuid' => 'required|uuid',
            'token' => 'required|string|max:128',
            'body' => 'required|string|max:2000',
        ]);

        $conv = ChatConversation::where('uuid', $data['uuid'])
            ->where('guest_token', $data['token'])->first();

        if (!$conv) {
            return response()->json(['ok' => false, 'message' => 'Conversation not found'], 404);
        }
        if ($conv->isBlocked() || $this->isBlocked($request->ip(), $conv->guest_token)) {
            return response()->json(['ok' => false, 'message' => 'You have been blocked from chat.'], 403);
        }
        if (in_array($conv->status, ['closed', 'resolved'])) {
            $conv->update(['status' => 'open']); // reopen on new guest message
        }

        $msg = $conv->messages()->create([
            'sender' => 'guest',
            'body' => trim($data['body']),
            'ip' => $request->ip(),
        ]);
        $conv->increment('admin_unread');
        $conv->update(['last_message_at' => now(), 'last_guest_seen_at' => now()]);
        // Guest has seen admin messages up to now
        $conv->messages()->where('sender', 'admin')->where('is_read', false)->update(['is_read' => true]);
        $conv->update(['guest_unread' => 0]);

        $this->publishToNode($conv, $msg);

        return response()->json(['ok' => true, 'message' => $this->formatMsg($msg)]);
    }

    /** Fallback polling (used when WS unreachable) + marks admin messages read. */
    public function poll(Request $request)
    {
        $data = $request->validate([
            'uuid' => 'required|uuid',
            'token' => 'required|string|max:128',
            'after_id' => 'nullable|integer|min:0',
        ]);

        $conv = ChatConversation::where('uuid', $data['uuid'])
            ->where('guest_token', $data['token'])->first();

        if (!$conv) {
            return response()->json(['ok' => false], 404);
        }

        $after = (int) ($data['after_id'] ?? 0);
        $msgs = $conv->messages()->where('id', '>', $after)->orderBy('id')->limit(100)->get();

        // Mark admin messages as read by guest
        $conv->messages()->where('sender', 'admin')->where('is_read', false)->update(['is_read' => true]);
        $conv->update(['guest_unread' => 0, 'last_guest_seen_at' => now()]);

        return response()->json([
            'ok' => true,
            'admin_online' => $this->adminOnline(),
            'status' => $conv->status,
            'messages' => $msgs->map(fn($m) => $this->formatMsg($m)),
        ]);
    }

    /** Lightweight online check for the widget (drives online vs offline form). */
    public function status()
    {
        return response()->json(['ok' => true, 'admin_online' => $this->adminOnline()]);
    }

    // ---------- helpers ----------

    private function isBlocked(?string $ip, ?string $token): bool
    {
        if (!$ip && !$token) return false;
        return ChatBlock::where(function ($q) use ($ip, $token) {
            if ($ip) $q->orWhere('ip', $ip);
            if ($token) $q->orWhere('guest_token', $token);
        })->exists();
    }

    private function formatMsg(ChatMessage $m): array
    {
        return [
            'id' => $m->id,
            'sender' => $m->sender,
            'body' => $m->sender === 'system' ? $m->body : $m->body,
            'at' => $m->created_at->toISOString(),
        ];
    }

    private function adminOnline(): bool
    {
        try {
            $res = Http::timeout(2)->get(rtrim(config('chat.node_url'), '/') . '/presence');
            if ($res->ok()) {
                return ((int) ($res->json('admins', 0))) > 0;
            }
        } catch (\Throwable $e) {
        }
        return true; // fail-open: show online form so messages are never lost
    }

    private function publishToNode(ChatConversation $conv, ChatMessage $msg): void
    {
        try {
            Http::withHeaders(['X-Chat-Secret' => config('chat.sync_secret')])
                ->timeout(2)
                ->post(rtrim(config('chat.node_url'), '/') . '/publish', [
                    'uuid' => $conv->uuid,
                    'name' => $conv->name,
                    'message' => $this->formatMsg($msg),
                ]);
        } catch (\Throwable $e) {
            // polling fallback covers delivery — never break the request
        }
    }

    private function geoLookup(?string $ip): array
    {
        if (!$ip || in_array($ip, ['127.0.0.1', '::1'])) return [];
        try {
            // Free, no key needed. Fail-open with short timeout.
            $res = Http::timeout(2)->get("http://ip-api.com/json/{$ip}?fields=country,city,status");
            if ($res->ok() && ($res->json('status') === 'success')) {
                return ['country' => $res->json('country'), 'city' => $res->json('city')];
            }
        } catch (\Throwable $e) {
        }
        return [];
    }
}
