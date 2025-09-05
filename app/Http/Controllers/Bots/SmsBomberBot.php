<?php

namespace App\Http\Controllers\Bots;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\BomberStatus;
use Illuminate\Support\Facades\Storage;

class SmsBomberBot extends Controller
{
    protected $telegram_api_url;

    public function __construct()
    {
        $this->telegram_api_url = "https://api.telegram.org/bot7744270031:AAHgPhZymp403U2EutSW5BOS6uSGaIgJHaM/";
    }

    public function index()
    {
        $status = BomberStatus::all();
        return view('bots.sms_bomber.index', compact('status'));
    }

    public function webhook(Request $request)
    {
        // Get the request data
        $update = $request->all();

        // Convert the data to JSON and save it for debugging
        // Storage::disk('local')->put('requests/saveFile_' . time() . '.json', json_encode($update, JSON_PRETTY_PRINT));

        // Check if message or edited message exists
        if (isset($update['message']) || isset($update['edited_message'])) {
            $messageData = $update['message'] ?? $update['edited_message'];
            $this->handleMessage($messageData);
        }

        return response('OK', 200);
    }

    protected function handleMessage($message)
    {
        $chat_id = $message['chat']['id'];
        $text = $message['text'] ?? '';

        if ($text === '/start_auto_liker' || $text === '/start') {
            $welcomeMessage = <<<EOD
👋 Welcome to SMS Bomber 🚀

Hey there! 🎉 You’ve just unlocked an amazing tool. Get ready to explore powerful features and have some fun! 😎

🔥 What can you do here?
✅ SMS Bomber
✅ CALL Bomber

Tap 👇🏻👇🏻👇🏻 and let’s go! 🚀
🔗 [Launch SMS Bomber](https://t.me/sms_sender_live_bot/startApp)
EOD;
            $this->sendMessage($chat_id, $welcomeMessage);
        }
    }

    protected function sendMessage($chat_id, $text)
    {
        $client = new Client();
        $client->post($this->telegram_api_url . 'sendMessage', [
            'json' => [
                'chat_id' => $chat_id,
                'text' => $text,
                'parse_mode' => 'Markdown',
                'disable_web_page_preview' => true,
                'reply_markup' => [
                    'inline_keyboard' => [
                        [
                            [
                                'text' => '🚀 Launch SMS Bomber',
                                'url' => 'https://t.me/sms_sender_live_bot/startApp'
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }


}
