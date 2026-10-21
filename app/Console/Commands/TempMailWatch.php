<?php

namespace App\Console\Commands;

use App\Events\InboxMessageReceived;
use App\Http\Controllers\TempMailController;
use App\Models\TempInbox;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Scheduled sweep: re-checks recently active temp inboxes over the catch-all
 * IMAP mailbox and pushes freshly arrived messages over Reverb. This is what
 * makes push work even when the owner does not poll:
 *
 *   schedule.php: $schedule->command('tempmail:watch')->everyMinute();
 */
class TempMailWatch extends Command
{
    protected $signature = 'tempmail:watch';

    protected $description = 'Watch active temp inboxes and push new messages over WebSocket';

    public function handle(TempMailController $webmailer): int
    {
        $window = (int) config('tempmail-api.watch_window_minutes', 30);

        $inboxes = TempInbox::query()
            ->active()
            ->where(function ($q) use ($window) {
                $q->where('last_seen_at', '>=', now()->subMinutes($window))
                  ->orWhere('created_at', '>=', now()->subMinutes($window));
            })
            ->get();

        if ($inboxes->isEmpty()) {
            $this->comment('No active inboxes to watch.');

            return self::SUCCESS;
        }

        $client = null;
        $pushed = 0;

        try {
            // One shared connection to the catch-allmailbox for the whole sweep.
            $client = $webmailer->connection();

            foreach ($inboxes as $inbox) {
                try {
                    $fetch = $webmailer->allMessages(new Request(['email' => $inbox->email]));

                    $messages = $fetch['messages'] ?? null;

                    if (! ($fetch['status'] ?? false) || ! is_array($messages)) {
                        continue;
                    }

                    Cache::put('tempinbox:'.$inbox->uuid.':last_watch', now()->toIso8601String(), now()->addHours(1));

                    $seen = array_flip(Cache::get('tempinbox:'.$inbox->uuid.':uids', []));

                    foreach (array_reverse($messages) as $message) {
                        $id = $message['id'] ?? null;

                        if (! $id || isset($seen[$id])) {
                            continue;
                        }

                        Cache::put(
                            'tempinbox:'.$inbox->uuid.':uids',
                            array_merge(Cache::get('tempinbox:'.$inbox->uuid.':uids', []), [$id]),
                            now()->addHours(48)
                        );

                        InboxMessageReceived::dispatch($inbox, $message);
                        $pushed++;
                    }
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        } catch (\Throwable $e) {
            report($e);
            $this->error('IMAP connection failed: '.$e->getMessage());

            return self::FAILURE;
        } finally {
            try {
                $client?->disconnect();
            } catch (\Throwable $e) {
            }
        }

        $this->info("Watched {$inboxes->count()} inbox(es), pushed {$pushed} new message(s).");

        return self::SUCCESS;
    }
}
