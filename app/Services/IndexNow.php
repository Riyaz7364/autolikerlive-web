<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * IndexNow (Bing/Yandex) instant URL submission.
 * Best-effort: failures are logged and never break the request.
 */
class IndexNow
{
    public static function key(): string
    {
        return (string) config('services.indexnow.key', '');
    }

    /**
     * @param string[]|string $urls Absolute URLs
     */
    public static function submit(array|string $urls): void
    {
        $key = self::key();
        if ($key === '') {
            return;
        }

        $list = array_values(array_unique(array_filter((array) $urls)));
        if (! $list) {
            return;
        }

        try {
            Http::timeout(10)->post('https://api.indexnow.org/indexnow', [
                'host' => 'www.autolikerlive.com',
                'key' => $key,
                'keyLocation' => 'https://www.autolikerlive.com/' . $key . '.txt',
                'urlList' => array_slice($list, 0, 10000),
            ]);
        } catch (\Throwable $e) {
            Log::warning('IndexNow submit failed', ['error' => $e->getMessage()]);
        }
    }

    public static function submitPath(string $path): void
    {
        self::submit('https://www.autolikerlive.com/' . ltrim($path, '/'));
    }
}
