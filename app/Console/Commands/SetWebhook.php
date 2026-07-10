<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class SetWebhook extends Command
{
    protected $signature = 'telegram:set-webhook';
    protected $description = 'Set the Telegram webhook URL';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $client = new Client();
        $webhookUrl = route('telegram.webhook');

        // Replace with your ngrok URL during testing if running locally
        // e.g., $webhookUrl = 'https://your-ngrok-url.ngrok.io/api/telegram/webhook';

        $response = $client->get('https://api.telegram.org/bot7278889500:AAFxET3cFjzuDBDESSPuzguQlO75k2rF7WE/setWebhook', [
            'query' => [
                'url' => 'https://www.autolikerlive.com/api/telegram/webhook'
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $this->info('Webhook set successfully.');
        } else {
            $this->error('Failed to set webhook: ' . $response->getBody());
        }
    }
}
