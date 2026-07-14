<?php

namespace App\Services;

use GuzzleHttp\Client;
use RuntimeException;

class AiGameService
{
    protected Client $http;

    public function __construct()
    {
        $this->http = new Client([
            'connect_timeout' => 15,
            'timeout' => 30,
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.aicredit.key'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Generate AI text using a dynamic role + prompt template + field values.
     *
     * @param string $role      The AI persona/system role
     * @param string $prompt    Prompt template with {field_key} placeholders
     * @param array  $fields    [['key' => 'name', 'label' => 'Your Name', 'value' => 'John'], ...]
     * @param int    $maxTokens
     */
    public function generate(string $role, string $prompt, array $fields, int $maxTokens = 300): string
    {
        $replacements = [];
        foreach ($fields as $field) {
            $key = $field['key'] ?? $field['field_key'] ?? '';
            $value = $field['value'] ?? $field['field_value'] ?? '';
            $label = $field['label'] ?? $field['field_label'] ?? $key;
            $replacements['{' . $key . '}'] = $value ?: "[{$label}]";
        }

        $filledPrompt = str_replace(array_keys($replacements), array_values($replacements), $prompt);

        return $this->chat($role, $filledPrompt, $maxTokens);
    }

    public function marriageFuture(string $sessionName, string $dob, string $marriageDate): string
    {
        $age = $dob ? $this->calculateAge($dob) : 'unknown age';
        $marriageYear = $marriageDate ? date('Y', strtotime($marriageDate)) : date('Y');
        $marriedDuration = $marriageDate ? $this->marriageDuration($marriageDate) : 'just married';

        $role = 'You are a savage, hilarious fortune teller for a game called "Your Future After Marriage". You mix dark humor with actual good predictions.';

        $prompt = "The player: {$sessionName}, age {$age}, marrying in {$marriageYear} ({$marriedDuration}).

Generate a FUNNY, SAVAGE marriage future prediction.
Answer MUST be exactly 10-15 words total. Short and punchy.
Do NOT use any emojis.

MIX good fortunes AND dark misfortunes — contrast is what makes it funny.

EXAMPLES (follow this vibe, create your own):
You will be found in a blue drum if you don't listen wife
You will be happy until mountain trip with in-laws
Wife will love you until best friend gets married
You will own a mansion! It is in-laws spare room
You will get 5-star meals from mother-in-law restaurant bill

CRITICAL RULES:
- NEVER use: kill, murder, dead, death, emojis
- You MAY use: bury, finish, gone, blue drum, mountain trip, finished
- Reference viral incidents subtly
- Answer must be 10-15 words ONLY
- Use the player's name naturally
- Do NOT include labels, prefixes, quotes, or emojis
- Each result should feel unique and personal";

        return $this->chat($role, $prompt, 200);
    }

    protected function chat(string $role, string $prompt, int $maxTokens = 300): string
    {
        $model = config('services.aicredit.model');
        $baseUrl = rtrim((string) config('services.aicredit.base_url'), '/');

        $messages = [];
        if (!empty($role)) {
            $messages[] = ['role' => 'system', 'content' => $role];
        }
        $messages[] = ['role' => 'user', 'content' => $prompt];

        $response = $this->http->post("{$baseUrl}/chat/completions", [
            'json' => [
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.9,
                'max_tokens' => $maxTokens,
            ],
        ]);

        $payload = json_decode((string) $response->getBody(), true);
        if (!is_array($payload)) {
            throw new RuntimeException('AI Credits response was not valid JSON.');
        }

        return $this->extractText($payload);
    }

    protected function extractText(array $payload): string
    {
        $text = $payload['choices'][0]['message']['content'] ?? '';
        $text = trim($text);
        $text = preg_replace('/^["\']+|["\']+$/s', '', $text);
        $text = trim($text);

        if (empty($text)) {
            throw new RuntimeException('AI Credits returned empty response.');
        }

        return $text;
    }

    protected function calculateAge(string $dob): int
    {
        try {
            $birth = new \Carbon\Carbon($dob);
            return (int) $birth->age;
        } catch (\Exception $e) {
            return 0;
        }
    }

    protected function marriageDuration(string $marriageDate): string
    {
        try {
            $married = new \Carbon\Carbon($marriageDate);
            $now = now();
            $years = $married->diffInYears($now);
            $months = $married->diffInMonths($now) % 12;
            if ($years > 0) {
                return "{$years} year" . ($years > 1 ? 's' : '') . ($months > 0 ? " and {$months} month" . ($months > 1 ? 's' : '') : '');
            }
            return "{$months} month" . ($months > 1 ? 's' : '');
        } catch (\Exception $e) {
            return 'a short time';
        }
    }
}
