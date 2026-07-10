<?php

namespace App\Http\Controllers\Bots;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AutolikerLiveBot extends Controller
{
    protected $telegram_api_url;

    public function __construct()
    {
        $this->telegram_api_url = "https://api.telegram.org/bot7301015849:AAGLUJTzUbxOmazgp2MTlKilhg7NB25SfGA/";
    }

    public function webhook(Request $request)
    {
        $update = $request->all();
        // return ($update);


        // Storage::disk('local')->put('requests/saveFile_' . time() . '.json', json_encode($update, JSON_PRETTY_PRINT));

        if (isset($update['message']) || isset($update['edited_message'])) {
            $this->handleMessage($update['message'] ?? $update['edited_message']);
        }

        return response('OK', 200);
    }


    protected function handleMessage($message)
    {
        $chat_id = $message['chat']['id'];
        $text = $message['text'] ?? '';
        $first_name = $message['chat']['first_name'] ?? 'User';

        if ($text === '/start' || $text === '/start@autolikerlive_bot') {
            $welcomeMessage = <<<EOD
👋 Welcome, {$first_name}, to AutolikerLive Bot 🚀

Hey there! 🎉 You’ve just unlocked an amazing tool. Get ready to explore powerful features and have some fun! 😎

🔥 What can you do here?
✅ SMS Bomber/Call Bomber
🔗 [👉🏻](https://t.me/sms_sender_live_bot/startApp)


EOD;

            $buttons = [
                ['text' => 'SMS Bomber', 'url' => 'https://t.me/sms_sender_live_bot/startApp'],
            ];
            $this->sendMessage($chat_id, $welcomeMessage, $buttons);

        }
    }

    protected function sendMessage($chat_id, $text, $buttons = [])
    {

        $keyboard = [
            'inline_keyboard' => []
        ];

        foreach ($buttons as $button) {
            $keyboard['inline_keyboard'][] = [
                ['text' => $button['text'], 'url' => $button['url']]
            ];
        }

        $client = new Client();
        $client->post($this->telegram_api_url . 'sendMessage', [
            'json' => [
                'chat_id' => $chat_id,
                'text' => $text,
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode($keyboard),
            ]
        ]);
    }

}
