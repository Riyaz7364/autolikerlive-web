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
}
