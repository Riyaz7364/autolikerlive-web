<?php

namespace App\Services\NetShort;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Share-link -> original episode files, LIVE upstream only (no DB).
 *
 *   1. Extract linkId from the OneLink URL (deep_link_value).
 *   2. Resolve via /auth/app_link_startV2 -> shortPlayId + episodeId.
 *   3. Fetch episode/detail_info in 720p + 1080p (independent).
 *
 * Upstream JWT is cached (file/array) and auto-refreshed: any request
 * rejected for auth triggers one fresh visitor login, then a single retry.
 */
class NetShortShare
{
    public const DEVICE_CODE = 'web-main-site';

    public const JWT_CACHE_KEY = 'netshort:web-jwt';

    public const JWT_TTL = 518400; // 6 days (upstream timeout is ~7)

    /**
     * @return array{linkId: string, shortPlayId: string, episodeId: string, episodeNo: int, name: ?string, files: array{720p: ?string, 1080p: ?string}}
     */
    public static function fetchEpisode(string $input): array
    {
        $linkId = self::extractLinkId($input);
        if ($linkId === '') {
            throw new \InvalidArgumentException('Paste a NetShort share link or linkId.');
        }

        $resolved = self::post('/prod-app-api/auth/app_link_startV2', [
            'linkId' => $linkId, 'deepLinkValue' => $linkId,
        ]);

        $inner = is_array($resolved['data']['data'] ?? null) ? $resolved['data']['data'] : [];
        $vo = is_array($inner['umsAppShareLinkVo'] ?? null) ? $inner['umsAppShareLinkVo'] : [];
        $shortPlayId = isset($inner['shortPlayId']) ? (string) $inner['shortPlayId']
            : (isset($vo['shortPlayId']) ? (string) $vo['shortPlayId'] : null);
        $episodeId = isset($vo['episodeId']) ? (string) $vo['episodeId']
            : (isset($inner['playEpisodeId']) ? (string) $inner['playEpisodeId'] : null);

        if (! $shortPlayId || ! $episodeId) {
            throw new \RuntimeException('Link resolved but contained no episode.');
        }

        $episodeNo = max(1, (int) ($vo['episodeNo'] ?? $inner['episodeNo'] ?? 1));
        $files = [];
        foreach (['720p', '1080p'] as $clarity) {
            try {
                $res = self::post('/prod-app-api/video/shortPlay/base/episode/detail_info', [
                    'episodeId' => $episodeId, 'episodeNo' => $episodeNo, 'episodeType' => 1,
                    'playClarity' => $clarity, 'shortPlayId' => $shortPlayId,
                ]);
                $files[$clarity] = self::extractPlayUrl($res['data'] ?? null);
            } catch (\Throwable) {
                $files[$clarity] = null;
            }
        }

        return [
            'linkId' => $linkId,
            'shortPlayId' => $shortPlayId,
            'episodeId' => $episodeId,
            'episodeNo' => $episodeNo,
            'name' => $vo['shortPlayName'] ?? null,
            'files' => ['720p' => $files['720p'] ?? null, '1080p' => $files['1080p'] ?? null],
        ];
    }

    /** Plaintext payload -> encrypted POST -> decoded reply (with one auto re-login). */
    public static function post(string $path, array $payload): array
    {
        $res = self::send($path, $payload, self::jwt());

        if (self::tokenRejected($res)) {
            Cache::forget(self::JWT_CACHE_KEY);
            $res = self::send($path, $payload, self::jwt(true));
        }

        return $res;
    }

    // -----------------------------------------------------------------

    protected static function send(string $path, array $payload, ?string $jwt): array
    {
        $enc = NetShortEncoder::fromConfig()->encode($payload);
        $host = rtrim((string) config('netshort.host'), '/');

        $response = Http::withHeaders(NetShortEncoder::buildHeaders($jwt, $enc['encryptKey'], ['deviceCode' => self::DEVICE_CODE]))
            ->withBody($enc['body'], 'application/json')
            ->timeout((int) config('netshort.timeout', 25))
            ->post($host.'/'.ltrim($path, '/'));

        $http = $response->status();
        $respKey = null;
        foreach ($response->headers() as $k => $v) {
            if (strtolower((string) $k) === 'encrypt-key') {
                $respKey = is_array($v) ? ($v[0] ?? null) : $v;
                break;
            }
        }

        if ($respKey === null) {
            $raw = $response->body();
            $data = json_decode($raw, true);

            return ['http' => $http, 'data' => json_last_error() === JSON_ERROR_NONE ? $data : $raw];
        }

        try {
            $raw = NetShortEncoder::fromConfig()->decodeResponse($respKey, $response->body());
        } catch (\Throwable $e) {
            throw new \RuntimeException('Upstream HTTP '.$http.' but decode failed: '.$e->getMessage());
        }
        $data = json_decode($raw, true);

        return ['http' => $http, 'data' => json_last_error() === JSON_ERROR_NONE ? $data : $raw];
    }

    protected static function jwt(bool $fresh = false): ?string
    {
        if ($fresh) {
            Cache::forget(self::JWT_CACHE_KEY);
        }

        return Cache::remember(self::JWT_CACHE_KEY, self::JWT_TTL, function () {
            $res = self::send('/prod-app-api/auth/login', [
                'deviceCode' => self::DEVICE_CODE, 'deviceId' => null,
                'model' => 'Postman', 'os' => 'Android', 'osVer' => '14',
                'appVer' => '1.0.0', 'source' => 'visitor',
            ], null);

            $token = $res['data']['data']['token'] ?? null;
            if (! $token) {
                throw new \RuntimeException('Upstream login failed: '.substr(json_encode($res['data']), 0, 200));
            }

            return $token;
        });
    }

    protected static function tokenRejected(array $res): bool
    {
        if ($res['http'] === 401 || $res['http'] === 403) {
            return true;
        }
        $data = $res['data'];
        if (! is_array($data) || ($data['code'] ?? 200) === 200) {
            return false;
        }
        if (in_array($data['code'] ?? null, [401, 403], true)) {
            return true;
        }
        $msg = mb_strtolower((string) ($data['msg'] ?? ''));
        foreach (['token', 'auth', 'login', '登录', '过期', '失效', 'unauthorized', 'expire', 'invalid'] as $needle) {
            if ($needle !== '' && str_contains($msg, $needle)) {
                return true;
            }
        }

        return false;
    }

    public static function extractLinkId(string $text): string
    {
        $t = trim($text);
        if ($t === '') {
            return '';
        }
        if (preg_match('/deep_link_value=([^&#\s]+)/', $t, $m)) {
            return strtolower(trim(urldecode($m[1])));
        }
        if (preg_match('/\b[0-9a-fA-F]{32}\b/', $t, $m)) {
            return strtolower($m[0]);
        }
        if (str_starts_with($t, 'http')) {
            throw new \InvalidArgumentException('That URL has no deep_link_value= parameter — paste the NetShort share URL, or just the 32-char linkId.');
        }

        return $t;
    }

    public static function extractPlayUrl(mixed $data): ?string
    {
        if (! is_array($data)) {
            return null;
        }
        $inner = is_array($data['data'] ?? null) ? $data['data'] : $data;
        $first = $inner['episodeList'][0] ?? $inner;

        foreach (['playVoucher', 'playUrl', 'playAddr', 'videoUrl', 'url', 'playURL'] as $k) {
            if (! empty($first[$k]) && is_string($first[$k])) {
                return $first[$k];
            }
            if (! empty($inner[$k]) && is_string($inner[$k])) {
                return $inner[$k];
            }
        }

        return null;
    }
}
