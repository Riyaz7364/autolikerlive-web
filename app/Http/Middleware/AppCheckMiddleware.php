<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Kreait\Firebase\Factory;
use RuntimeException;
use Throwable;

class AppCheckMiddleware
{
    /**
     * Verifies the X-Firebase-AppCheck JWT against our Firebase project.
     *
     * The app never sends the debug-token UUID manually. The Firebase App
     * Check SDK obtains a token and sends it in this header; the backend
     * verifies the JWT signature against Google's App Check JWKS and checks
     * the project number and Android app ID.
     *
     * Escape hatch for the test suite only: services.firebase.appcheck_enforce=false
     * lets feature tests run without Firebase credentials. Never disable in
     * production.
     */
    public function handle(Request $request, Closure $next)
    {
        $logAccepted = (bool) config('services.firebase.appcheck_log_accepted', false);

        if ($logAccepted) {
            Log::info('App Check request received.', [
                'method' => $request->method(),
                'path' => $request->path(),
                'ip' => $request->ip(),
                'has_app_check_header' => $request->hasHeader('X-Firebase-AppCheck'),
                'user_agent' => $request->userAgent(),
            ]);
        }

        if (in_array(config('services.firebase.appcheck_enforce', true), [false, 'disable'], true)) {
            $request->attributes->set('appcheck.user', 'app-instance');

            return $next($request);
        }

        $appCheckToken = $request->header('X-Firebase-AppCheck');

        if (!$appCheckToken) {
            if ($logAccepted) {
                Log::warning('App Check header missing.', [
                    'method' => $request->method(),
                    'path' => $request->path(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }

            return response()->json(['error' => 'Invalid request taken'], 401);
        }

        $projectId = trim((string) config('services.firebase.project_id'));
        $projectNumber = trim((string) config('services.firebase.project_number'));
        $expectedAppIds = $this->expectedAppIds();
        $credentials = config('services.firebase.credentials');

        try {
            $serviceAccount = $this->loadServiceAccount($credentials, $projectId);

            $factory = (new Factory())
                ->withProjectId($projectNumber)
                ->withServiceAccount($serviceAccount);

            $verified = $factory->createAppCheck()->verifyToken($appCheckToken);

            $expectedIssuer = 'https://firebaseappcheck.googleapis.com/'.$projectNumber;
            if (rtrim($verified->token->iss, '/') !== $expectedIssuer) {
                throw new RuntimeException('App Check token issuer does not match the configured project number.');
            }

            if ($expectedAppIds !== [] && !in_array($verified->appId, $expectedAppIds, true)) {
                Log::warning('App Check token app ID mismatch.', [
                    'expected_app_ids' => $expectedAppIds,
                    'token_app_id' => $verified->appId,
                    'aud' => $verified->token->aud,
                    'iss' => $verified->token->iss,
                    'sub' => $verified->token->sub,
                    'method' => $request->method(),
                    'path' => $request->path(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);

                return response()->json(['error' => 'Unknown Invalid request taken'], 403);
            }

            $request->attributes->set('appcheck.user', 'app-instance');
            $request->attributes->set('appcheck.app_id', $verified->appId);
            $request->attributes->set('appcheck.claims', [
                'aud' => $verified->token->aud,
                'iss' => $verified->token->iss,
                'sub' => $verified->token->sub,
                'app_id' => $verified->appId,
            ]);

            if ($logAccepted) {
                Log::info('App Check token accepted.', [
                    'app_id' => $verified->appId,
                    'method' => $request->method(),
                    'path' => $request->path(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            }

            $response = $next($request);

            if (config('tempmail-api.log_responses', false)
                && str_starts_with($request->path(), 'api/tempmail/')) {
                Log::info('TempMail API response.', [
                    'method' => $request->method(),
                    'path' => $request->path(),
                    'status' => $response->getStatusCode(),
                    'body' => $this->responseBodyForLog($response),
                ]);
            }

            if ($logAccepted) {
                Log::info('App Check request completed.', [
                    'app_id' => $verified->appId,
                    'method' => $request->method(),
                    'path' => $request->path(),
                    'status' => $response->getStatusCode(),
                    'user_agent' => $request->userAgent(),
                ]);
            }

            return $response;
        } catch (Throwable $e) {
            Log::warning('App Check verification failed.', [
                'reason' => $e->getMessage(),
                'exception' => $e::class,
                'claims' => $this->unverifiedClaims($appCheckToken),
                'method' => $request->method(),
                'path' => $request->path(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'project_id' => $projectId,
                'project_number' => $projectNumber,
                'expected_app_ids' => $expectedAppIds,
                'credentials_file' => is_string($credentials) ? $credentials : get_debug_type($credentials),
                'credentials_file_exists' => is_string($credentials) && is_file($credentials),
            ]);

            return response()->json(['error' => 'Unknown Invalid request taken'], 403);
        }
    }

    /**
     * Build a redacted, size-limited representation of an API response.
     */
    private function responseBodyForLog(mixed $response): mixed
    {
        $content = $response->getContent();

        if (!is_string($content) || $content === '') {
            return null;
        }

        $decoded = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return Str::limit($content, 4000);
        }

        $redacted = $this->redactForLog($decoded);
        $encoded = json_encode($redacted, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $encoded === false ? $redacted : Str::limit($encoded, 12000);
    }

    /**
     * Remove secrets from a decoded response before writing it to logs.
     */
    private function redactForLog(mixed $value): mixed
    {
        if (!is_array($value)) {
            return $value;
        }

        $redacted = [];

        foreach ($value as $key => $item) {
            $normalized = strtolower((string) $key);

            if (in_array($normalized, [
                'inbox_token',
                'email_token',
                'auth',
                'token',
                'password',
                'secret',
                'authorization',
                'x-firebase-appcheck',
            ], true)) {
                $redacted[$key] = '[redacted]';
                continue;
            }

            if ($normalized === 'channel'
                && is_string($item)
                && str_starts_with($item, 'inbox.')) {
                $redacted[$key] = 'inbox.[redacted]';
                continue;
            }

            $redacted[$key] = $this->redactForLog($item);
        }

        return $redacted;
    }

    /**
     * App IDs allowed to mint App Check tokens for this project.
     *
     * FIREBASE_APP_IDS may contain a comma-separated list (release + debug).
     * FIREBASE_APP_ID remains supported as a single-value fallback.
     *
     * @return array<int, string>
     */
    private function expectedAppIds(): array
    {
        $configured = config('services.firebase.app_ids', []);

        if (!is_array($configured)) {
            $configured = [$configured];
        }

        $appIds = array_values(array_filter(array_map(
            static fn ($appId) => is_string($appId) ? trim($appId) : '',
            $configured
        )));

        if ($appIds !== []) {
            return $appIds;
        }

        $single = trim((string) config('services.firebase.app_id', ''));

        return $single === '' ? [] : [$single];
    }

    /**
     * Load and validate the Firebase service-account JSON.
     *
     * Accepts an array (useful for tests), an inline JSON string, or a path to
     * a JSON file. The file must belong to FIREBASE_PROJECT_ID.
     *
     * @return array<string, mixed>
     */
    private function loadServiceAccount(mixed $credentials, string $projectId): array
    {
        if (is_array($credentials)) {
            $serviceAccount = $credentials;
        } elseif (is_string($credentials) && trim($credentials) !== '') {
            $value = trim($credentials);

            if (str_starts_with($value, '{')) {
                $serviceAccount = json_decode($value, true);
            } elseif (is_file($value) && is_readable($value)) {
                $serviceAccount = json_decode((string) file_get_contents($value), true);
            } else {
                throw new RuntimeException('Firebase App Check credentials file is missing or unreadable.');
            }
        } else {
            throw new RuntimeException('Firebase App Check credentials are not configured.');
        }

        if (!is_array($serviceAccount)) {
            throw new RuntimeException('Firebase App Check credentials are not valid JSON.');
        }

        foreach (['project_id', 'client_email', 'private_key'] as $key) {
            if (!isset($serviceAccount[$key]) || !is_string($serviceAccount[$key]) || $serviceAccount[$key] === '') {
                throw new RuntimeException("Firebase App Check credentials are missing {$key}.");
            }
        }

        if ($projectId !== '' && $serviceAccount['project_id'] !== $projectId) {
            throw new RuntimeException('Firebase App Check service-account project_id does not match FIREBASE_PROJECT_ID.');
        }

        return $serviceAccount;
    }

    /**
     * Decode claims for diagnostics only. This is NOT verification; the
     * signature is checked separately by the Firebase SDK. Never log the
     * token itself.
     *
     * @return array<string, mixed>
     */
    private function unverifiedClaims(string $token): array
    {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            return ['format' => 'not-a-jwt', 'length' => strlen($token)];
        }

        $payload = strtr($parts[1], '-_', '+/');
        $padding = strlen($payload) % 4;
        if ($padding > 0) {
            $payload .= str_repeat('=', 4 - $padding);
        }

        $decoded = base64_decode($payload, true);
        if ($decoded === false) {
            return ['format' => 'invalid-base64'];
        }

        $claims = json_decode($decoded, true);
        if (!is_array($claims)) {
            return ['format' => 'invalid-json'];
        }

        return array_intersect_key($claims, array_flip([
            'aud', 'iss', 'sub', 'app_id', 'iat', 'exp',
        ]));
    }
}
