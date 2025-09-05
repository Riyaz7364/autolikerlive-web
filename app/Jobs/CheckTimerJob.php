<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\TiktokTimer;

class CheckTimerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chat_id;

    public function __construct($chat_id)
    {
        $this->chat_id = $chat_id;
    }

    public function handle()
    {
        $tiktokTimer = TiktokTimer::where('id', $this->chat_id)
            ->where('updated_at', '>=', now()->subMinutes(10))
            ->first();

        if ($tiktokTimer) {
            // Send /start button
            $this->sendStartButton($this->chat_id);
        }
    }

    protected function sendStartButton($chat_id)
    {
        $keyboard = [
            'keyboard' => [['/start']],
            'resize_keyboard' => true,
        ];

        $this->sendMessage($chat_id, 'Click /start to begin.', $keyboard);
    }

    protected function sendMessage($chat_id, $text, $keyboard = null)
    {
        $client = new \GuzzleHttp\Client();
        $payload = [
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => json_encode($keyboard),
        ];

        $client->post('https://api.telegram.org/bot7278889500:AAFxET3cFjzuDBDESSPuzguQlO75k2rF7WE/sendMessage', [
            'json' => $payload
        ]);
    }
}
