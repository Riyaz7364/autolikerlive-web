<?php

namespace App\Http\Controllers;

use App\Models\ChatBlock;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatAdminController extends Controller
{
    /** Inbox list with filters + counts. */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $q = ChatConversation::query()->orderByDesc('last_message_at');

        if (in_array($status, ['open', 'pending', 'resolved', 'closed', 'blocked'])) {
            $q->where('status', $status);
        }
        if ($s = trim((string) $request->get('s', ''))) {
            $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('ip', 'like', "%{$s}%")
                    ->orWhere('page_url', 'like', "%{$s}%");
            });
        }

        $conversations = $q->paginate(30)->withQueryString();
        $counts = [
            'all' => ChatConversation::count(),
            'open' => ChatConversation::where('status', 'open')->count(),
            'pending' => ChatConversation::where('status', 'pending')->count(),
            'unread' => ChatConversation::where('admin_unread', '>', 0)->sum('admin_unread'),
        ];

        return view('admin.chats.index', compact('conversations', 'counts', 'status'));
    }

    /** Thread view — marks guest messages read. */
    public function show(string $uuid)
    {
        $conv = ChatConversation::where('uuid', $uuid)->firstOrFail();
        $conv->messages()->where('sender', 'guest')->where('is_read', false)->update(['is_read' => true]);
        $conv->update(['admin_unread' => 0, 'last_admin_seen_at' => now()]);
        $messages = $conv->messages()->orderBy('id')->limit(500)->get();

        if (request()->wantsJson()) {
            return response()->json([
                'ok' => true,
                'conversation' => $conv,
                'messages' => $messages->map(fn($m) => [
                    'id' => $m->id, 'sender' => $m->sender, 'body' => $m->body,
                    'at' => $m->created_at->toISOString(),
                ]),
            ]);
        }

        return view('admin.chats.show', compact('conv', 'messages'));
    }

    /** Admin reply — HTTP source of truth, then relay via Node. */
    public function reply(Request $request, string $uuid)
    {
        $data = $request->validate(['body' => 'required|string|max:2000']);
        $conv = ChatConversation::where('uuid', $uuid)->firstOrFail();

        if ($conv->isBlocked()) {
            return back()->withErrors(['body' => 'Conversation is blocked. Unblock first.']);
        }

        $msg = $conv->messages()->create(['sender' => 'admin', 'body' => trim($data['body'])]);
        $conv->increment('guest_unread');
        $conv->update(['last_message_at' => now(), 'last_admin_seen_at' => now()]);
        if ($conv->status === 'pending') $conv->update(['status' => 'open']);

        $this->publishToNode($conv, $msg);

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'message' => ['id' => $msg->id, 'sender' => 'admin', 'body' => $msg->body, 'at' => $msg->created_at->toISOString()]]);
        }
        return back();
    }

    /** Status control: pending | resolve | close | reopen. */
    public function setStatus(Request $request, string $uuid)
    {
        $data = $request->validate(['status' => 'required|in:open,pending,resolved,closed']);
        $conv = ChatConversation::where('uuid', $uuid)->firstOrFail();
        $conv->update(['status' => $data['status']]);
        $conv->messages()->create(['sender' => 'system', 'body' => 'Status → ' . $data['status']]);
        return back()->with('success', 'Status updated.');
    }

    /** Private admin note (system message, hidden from guest widget). */
    public function note(Request $request, string $uuid)
    {
        $data = $request->validate(['body' => 'required|string|max:1000']);
        $conv = ChatConversation::where('uuid', $uuid)->firstOrFail();
        $conv->messages()->create(['sender' => 'system', 'body' => '📝 ' . trim($data['body'])]);
        return back()->with('success', 'Note saved.');
    }

    /** Block guest: conversation status + IP/token blocklist. */
    public function block(Request $request, string $uuid)
    {
        $data = $request->validate(['reason' => 'nullable|string|max:500']);
        $conv = ChatConversation::where('uuid', $uuid)->firstOrFail();
        $conv->update(['status' => 'blocked', 'blocked_reason' => $data['reason'] ?? null, 'blocked_at' => now()]);
        ChatBlock::firstOrCreate(['ip' => $conv->ip], ['guest_token' => $conv->guest_token, 'reason' => $data['reason'] ?? null]);
        if ($conv->guest_token) {
            ChatBlock::firstOrCreate(['guest_token' => $conv->guest_token], ['ip' => $conv->ip, 'reason' => $data['reason'] ?? null]);
        }
        $conv->messages()->create(['sender' => 'system', 'body' => '⛔ Blocked' . (!empty($data['reason']) ? ': ' . $data['reason'] : '')]);
        return back()->with('success', 'Visitor blocked.');
    }

    public function unblock(string $uuid)
    {
        $conv = ChatConversation::where('uuid', $uuid)->firstOrFail();
        $conv->update(['status' => 'open', 'blocked_reason' => null, 'blocked_at' => null]);
        ChatBlock::where('ip', $conv->ip)->delete();
        ChatBlock::where('guest_token', $conv->guest_token)->delete();
        $conv->messages()->create(['sender' => 'system', 'body' => '✅ Unblocked']);
        return back()->with('success', 'Visitor unblocked.');
    }

    public function destroy(string $uuid)
    {
        ChatConversation::where('uuid', $uuid)->firstOrFail()->delete();
        return redirect()->route('admin.chats.index')->with('success', 'Conversation deleted.');
    }

    public function export(string $uuid)
    {
        $conv = ChatConversation::where('uuid', $uuid)->firstOrFail();
        $msgs = $conv->messages()->orderBy('id')->get();
        $csv = "id,sender,body,at\n";
        foreach ($msgs as $m) {
            $csv .= $m->id . ',' . $m->sender . ',"' . str_replace('"', '""', $m->body) . '",' . $m->created_at->toDateTimeString() . "\n";
        }
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="chat-' . $conv->uuid . '.csv"',
        ]);
    }

    /** Unread total for title badge + sound polling. */
    public function unread()
    {
        $latestConv = ChatConversation::where('admin_unread', '>', 0)->orderByDesc('last_message_at')->first();
        $latest = null;
        if ($latestConv) {
            $lastGuest = $latestConv->messages()->where('sender', 'guest')->orderByDesc('id')->first();
            $latest = [
                'uuid' => $latestConv->uuid,
                'name' => $latestConv->name,
                'body' => \Str::limit($lastGuest->body ?? '', 120),
            ];
        }
        return response()->json([
            'ok' => true,
            'unread' => (int) ChatConversation::where('admin_unread', '>', 0)->sum('admin_unread'),
            'open' => (int) ChatConversation::where('status', 'open')->count(),
            'latest' => $latest,
        ]);
    }

    private function publishToNode(ChatConversation $conv, ChatMessage $msg): void
    {
        try {
            Http::withHeaders(['X-Chat-Secret' => config('chat.sync_secret')])
                ->timeout(2)
                ->post(rtrim(config('chat.node_url'), '/') . '/publish', [
                    'uuid' => $conv->uuid,
                    'name' => $conv->name,
                    'message' => ['id' => $msg->id, 'sender' => $msg->sender, 'body' => $msg->body, 'at' => $msg->created_at->toISOString()],
                ]);
        } catch (\Throwable $e) {
        }
    }
}
