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

    public function marriageFuture(string $sessionName, string $dob, string $marriageDate): string
    {
        $age = $dob ? $this->calculateAge($dob) : 'unknown age';
        $marriageYear = $marriageDate ? date('Y', strtotime($marriageDate)) : date('Y');
        $marriedDuration = $marriageDate ? $this->marriageDuration($marriageDate) : 'just married';

        $prompt = <<<PROMPT
        You are a fun, slightly savage fortune teller for a game called "Your Future After Marriage".
        The player: {$sessionName}, age {$age}, married/s marrying in {$marriageYear} ({$marriedDuration} married so far).

        Generate a FUNNY, ENTERTAINING marriage future prediction in 2-3 short sentences.
        Mix BOTH good fortunes AND horrible/funny misfortunes together.

        Good examples: "You will live in a mansion with a personal chef", "Your spouse will give you foot massages every night"
        Horrible examples: "You will end up sleeping on the couch for 3 years", "You will fight over the AC remote every summer"

        Rules:
        - Be creative, humorous, and specific
        - Use the player's name naturally
        - Keep it 2-3 sentences max, suitable for an image overlay
        - Do NOT be generic — make it feel personal and fun
        - Do NOT include any labels, prefixes, or quotes — just the prediction text
        - Make it feel like a social media viral game result
        PROMPT;

        return $this->chat($prompt, 200);
    }

    public function generalFuture(string $sessionName, string $dob, string $topic): string
    {
        $age = $dob ? $this->calculateAge($dob) : 'unknown age';

        $prompt = <<<PROMPT
        You are a fun fortune teller for a social media game. The player is {$sessionName}, age {$age}.
        Generate a short, fun, entertaining future prediction about: {$topic}.
        Mix good and funny/horrible outcomes. 2-3 sentences max.
        Use the player's name. Be creative and viral-worthy.
        Do NOT include labels, prefixes, or quotes — just the prediction text.
        PROMPT;

        return $this->chat($prompt, 200);
    }

    protected function chat(string $prompt, int $maxTokens = 200): string
    {
        $model = config('services.aicredit.model');
        $baseUrl = rtrim((string) config('services.aicredit.base_url'), '/');

        $response = $this->http->post("{$baseUrl}/chat/completions", [
            'json' => [
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
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
