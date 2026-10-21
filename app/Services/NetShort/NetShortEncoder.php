<?php

namespace App\Services\NetShort;

/**
 * NetShort request/response codec — standalone, framework-agnostic.
 *
 * Direct PHP port of the Python project's api_client.py + the decode
 * helpers in decoder_web.py (which mirror wrc.java:53-148 for requests
 * and tr2.java:253-291 for responses):
 *
 *   REQUEST : random 32-char [a-z0-9] key (cfh.H) -> AES-256-ECB encrypt
 *             the compact JSON body -> base64 `body`. The key itself is
 *             base64-encoded, RSA-encrypted (PKCS#1 v1.5) with the
 *             NetShort SERVER public key -> base64 `encrypt-key` header.
 *   RESPONSE: server seals its AES key to OUR app keypair, so the
 *             response `encrypt-key` header is RSA-decrypted with the APP
 *             private key -> 44-char base64 -> 32-byte AES key ->
 *             AES-256-ECB decrypt the base64 body.
 *
 * Keep this file dependency-free (no Laravel imports) so it can be
 * dropped/required anywhere you want. Use fromConfig() for the Laravel
 * wiring, or call the static methods directly with your own key material.
 */
class NetShortEncoder
{
    public const ALPHABET = 'abcdefghijklmnopqrstuvwxyz0123456789';

    // -----------------------------------------------------------------
    // Factory
    // -----------------------------------------------------------------

    /**
     * Encoder pre-loaded with the keys from Laravel config (or given args).
     */
    public static function fromConfig(?string $serverPubDerB64 = null, ?string $appPrivDerB64 = null): static
    {
        return new static(
            $serverPubDerB64 ?? (function_exists('config') ? config('netshort.server_pub') : null),
            $appPrivDerB64 ?? (function_exists('config') ? config('netshort.app_priv') : null),
        );
    }

    public function __construct(
        protected ?string $serverPubDerB64 = null,
        protected ?string $appPrivDerB64 = null,
    ) {}

    // -----------------------------------------------------------------
    // ENCODE (request side) — the method you asked for in its own file.
    // -----------------------------------------------------------------

    /**
     * Encode a plaintext payload into an upstream-ready pair.
     *
     * @param  array|string  $payload  array is JSON-encoded compactly (like fastjson), string is used as-is
     * @param  string|null   $aesKey   32-char [a-z0-9] key; random one generated when null (cfh.H())
     * @return array{body: string, encryptKey: string, aesKey: string}
     */
    public function encode(array|string $payload, ?string $aesKey = null): array
    {
        if ($this->serverPubDerB64 === null) {
            throw new \RuntimeException('Server public key not configured.');
        }

        $key = $aesKey ?? self::randomKey();
        $json = is_array($payload)
            ? json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            : (string) $payload;

        $cipher = self::aesEncrypt($key, $json);

        return [
            'body' => base64_encode($cipher),
            'encryptKey' => self::rsaEncryptKey($key, $this->serverPubDerB64),
            'aesKey' => $key,
        ];
    }

    /**
     * Build the upstream HTTP headers for an encoded (or pre-encoded) body.
     * Pass $jwt = null for the very first /auth/login call (no token yet).
     */
    public static function buildHeaders(?string $jwt, ?string $encryptKey, array $overrides = []): array
    {
        $cfg = function_exists('config') ? (array) config('netshort') : [];

        $headers = [
            'canary' => 'v2',
            'os' => '1',
            'User-Agent' => $cfg['user_agent'] ?? 'Mozilla/5.0',
            'start_type' => $cfg['start_type'] ?? 'hot',
            'version' => $cfg['version'] ?? '2.3.3',
            'versionCode' => $cfg['version_code'] ?? '245',
            'osVer' => $cfg['os_ver'] ?? '16',
            'network' => $cfg['network'] ?? 'wifi,hot,false',
            'Device-Code' => $overrides['deviceCode'] ?? $cfg['device_code'] ?? '0e702dd52acbdf0c',
            'model' => $overrides['model'] ?? $cfg['model'] ?? 'TECNO LK7k',
            'push_switch' => 'false',
            'timestamp' => (string) (int) (microtime(true) * 1000),
            'content-language' => $cfg['content_language'] ?? 'en_US',
            'Content-Type' => 'application/json',
        ];

        if ($jwt !== null && $jwt !== '') {
            $headers['Authorization'] = 'Bearer '.$jwt;
        }
        if ($encryptKey !== null && $encryptKey !== '') {
            $headers['encrypt-key'] = $encryptKey;
        }

        unset($overrides['deviceCode'], $overrides['model']);

        return array_merge($headers, $overrides);
    }

    // -----------------------------------------------------------------
    // DECODE (response side — needs only the response pair, no key)
    // -----------------------------------------------------------------

    /**
     * Decode an encrypted upstream response.
     *
     * @throws \RuntimeException with a human-readable reason on failure
     */
    public function decodeResponse(?string $encryptKeyHeader, ?string $body): string
    {
        if ($this->appPrivDerB64 === null) {
            throw new \RuntimeException('App private key not configured.');
        }
        if ($encryptKeyHeader === null || $encryptKeyHeader === '' || $body === null || $body === '') {
            throw new \RuntimeException('Needs BOTH the encrypt-key header and the body.');
        }

        try {
            $raw = self::b64d($encryptKeyHeader);
        } catch (\Throwable $e) {
            throw new \RuntimeException(
                'encrypt-key is not valid base64. Paste the response encrypt-key header exactly as captured (344 chars).'
            );
        }
        if (strlen($raw) !== 256) {
            throw new \RuntimeException(
                'encrypt-key should be 256 bytes of RSA, got '.strlen($raw).'. Paste the RESPONSE encrypt-key header (344 chars).'
            );
        }

        $keyB64 = self::rsaDecrypt($raw, $this->appPrivDerB64);

        if ($keyB64 === null || strlen($keyB64) !== 44 || ! self::isAscii($keyB64)) {
            throw new \RuntimeException(
                'This is a REQUEST encrypt-key — sealed to NetShort\'s server public key, so only the server can open it. '
                .'Copy the encrypt-key header from the RESPONSE instead '
                .'(it unwraps to exactly 44 ASCII chars = base64 of a 32-byte key).'
            );
        }

        $key = self::b64d($keyB64);
        if (! in_array(strlen($key), [16, 24, 32], true)) {
            throw new \RuntimeException('Unwrapped to '.strlen($key).' bytes — not a usable AES key.');
        }

        try {
            $ct = self::b64d($body);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Response body is not valid base64. Paste it exactly as captured.');
        }
        if ($ct === '' || strlen($ct) % 16 !== 0) {
            throw new \RuntimeException('Response body is not raw AES ciphertext (length must be a multiple of 16).');
        }

        return self::aesDecrypt($key, $ct);
    }

    /**
     * Decode a request body with its live AES key
     * (32-char literal or its 44-char base64 form).
     */
    public static function decodeRequest(string $keyStr, string $body): string
    {
        $key = self::normalizeKey($keyStr);

        try {
            $ct = self::b64d($body);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Body is not valid base64. Paste the send body exactly as captured.');
        }
        if ($ct === '') {
            throw new \RuntimeException('Body is empty.');
        }
        if (strlen($ct) % 16 !== 0) {
            throw new \RuntimeException('Body is '.strlen($ct).' bytes — not a multiple of 16, so it is not raw AES ciphertext.');
        }

        try {
            return self::aesDecrypt($key, $ct);
        } catch (\Throwable $e) {
            throw new \RuntimeException(
                'Wrong key — PKCS#7 padding did not validate. This body was encrypted with a different key than the one pasted.'
            );
        }
    }

    // -----------------------------------------------------------------
    // Primitives
    // -----------------------------------------------------------------

    public static function randomKey(int $length = 32): string
    {
        $out = '';
        $max = strlen(self::ALPHABET) - 1;
        for ($i = 0; $i < $length; $i++) {
            $out .= self::ALPHABET[random_int(0, $max)];
        }

        return $out;
    }

    public static function aesEncrypt(string $key, string $plain): string
    {
        $ct = openssl_encrypt($plain, 'AES-256-ECB', $key, OPENSSL_RAW_DATA);
        if ($ct === false) {
            throw new \RuntimeException('AES-256-ECB encryption failed: '.openssl_error_string());
        }

        return $ct;
    }

    public static function aesDecrypt(string $key, string $cipherRaw): string
    {
        $pt = openssl_decrypt($cipherRaw, 'AES-256-ECB', $key, OPENSSL_RAW_DATA);
        if ($pt === false) {
            throw new \RuntimeException('AES-256-ECB decryption failed (wrong key or corrupt body).');
        }

        return $pt;
    }

    /**
     * Seal a 32-char AES key to the server public key -> base64 header value.
     * Mirrors wrc.java:110,116,139 + api_client.build().
     */
    public static function rsaEncryptKey(string $keyStr, string $serverPubDerB64): string
    {
        $pub = openssl_pkey_get_public(self::derToPem($serverPubDerB64, 'PUBLIC KEY'));
        if ($pub === false) {
            throw new \RuntimeException('Invalid server public key.');
        }

        $ok = openssl_public_encrypt(base64_encode($keyStr), $encrypted, $pub, OPENSSL_PKCS1_PADDING);
        if (! $ok) {
            throw new \RuntimeException('RSA seal of AES key failed: '.openssl_error_string());
        }

        return base64_encode($encrypted); // 344 chars
    }

    /**
     * Open an RSA envelope with the app private key. Returns the raw bytes
     * (44-char base64 AES key on success, garbage otherwise — callers validate).
     */
    public static function rsaDecrypt(string $envelopeRaw, string $appPrivDerB64): ?string
    {
        $priv = openssl_pkey_get_private(self::derToPem($appPrivDerB64, 'PRIVATE KEY'));
        if ($priv === false) {
            throw new \RuntimeException('Invalid app private key.');
        }

        $ok = openssl_private_decrypt($envelopeRaw, $decrypted, $priv, OPENSSL_PKCS1_PADDING);

        return $ok ? $decrypted : null;
    }

    public static function derToPem(string $derB64, string $label): string
    {
        return "-----BEGIN {$label}-----\n".chunk_split($derB64, 64, "\n")."-----END {$label}-----\n";
    }

    /**
     * Tolerant base64 decode (whitespace + URL-safe, like decoder_web.b64d).
     */
    public static function b64d(string $s): string
    {
        $s = preg_replace('/\s+/', '', $s ?? '');
        $s = strtr($s, '-_', '+/');
        if ($s === '' || $s === null) {
            return '';
        }
        $out = base64_decode($s.str_repeat('=', (4 - strlen($s) % 4) % 4), true);
        if ($out === false) {
            throw new \RuntimeException('Invalid base64.');
        }

        return $out;
    }

    /**
     * Accept the 32-char literal key or its 44-char base64 form.
     */
    public static function normalizeKey(string $keyStr): string
    {
        $k = preg_replace('/\s+/', '', $keyStr ?? '');

        if (in_array(strlen($k), [16, 24, 32], true)) {
            return $k;
        }
        if (strlen($k) === 44) {
            try {
                $raw = self::b64d($k);
                if (in_array(strlen($raw), [16, 24, 32], true)) {
                    return $raw;
                }
            } catch (\Throwable) {
                // fall through to the error below
            }
        }

        throw new \RuntimeException(
            'AES key must be 16, 24 or 32 chars — cfh.H() generates exactly 32 random chars from [a-z0-9]. '
            .'You passed '.strlen($k).' chars.'
        );
    }

    protected static function isAscii(string $s): bool
    {
        return preg_match('/\A[\x20-\x7e]*\z/', $s) === 1;
    }
}
