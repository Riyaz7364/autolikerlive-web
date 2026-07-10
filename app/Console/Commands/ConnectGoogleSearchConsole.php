<?php

namespace App\Console\Commands;

use App\Services\GoogleSearchConsoleKeywordResearch;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Throwable;

class ConnectGoogleSearchConsole extends Command
{
    protected $signature = 'gsc:connect {--redirect-uri= : OAuth redirect URI to use} {--access-token= : Store an existing Google OAuth access token directly}';

    protected $description = 'Connect Google Search Console OAuth access token for daily blog keyword research.';

    public function handle(GoogleSearchConsoleKeywordResearch $research): int
    {
        $directAccessToken = trim((string) $this->option('access-token'));
        if ($directAccessToken !== '') {
            try {
                $research->storeAccessToken($directAccessToken);
            } catch (Throwable $e) {
                $this->error($e->getMessage());
                return self::FAILURE;
            }

            $this->info('Google Search Console access token stored in storage/app.');
            return self::SUCCESS;
        }

        $configuredRedirect = config('services.google.redirect');
        $defaultRedirectUri = $configuredRedirect ?: rtrim((string) config('app.url'), '/') . '/gsc/oauth2callback';
        $redirectUri = (string) ($this->option('redirect-uri') ?: $defaultRedirectUri);
        $state = Str::lower(Str::random(32));

        try {
            $url = $research->authorizationUrl($redirectUri, $state);
        } catch (Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        $this->info('Open this Google authorization URL in your browser:');
        $this->line($url);
        $this->newLine();
        $this->warn('After approving, Google will redirect to a confirmation page. Copy the full final URL from the browser address bar, including the #access_token fragment, and paste it here.');
        $this->line('OAuth client ID used: ' . (string) config('services.google.client_id'));
        $this->line('Redirect URI used: ' . $redirectUri);

        $callbackUrl = trim((string) $this->ask('Paste final redirect URL'));
        $params = $this->parseCallbackParameters($callbackUrl);

        $returnedState = (string) ($params['state'] ?? '');
        if ($returnedState !== $state) {
            $this->error('OAuth state did not match. Please run php artisan gsc:connect again and use the newest Google authorization URL.');
            $this->line('Expected state: ' . $state);
            $this->line('Returned state: ' . ($returnedState ?: '(missing)'));
            return self::FAILURE;
        }

        $accessToken = (string) ($params['access_token'] ?? '');
        if ($accessToken === '') {
            $this->error('No access_token found in the pasted URL. Make sure you copy the full URL including everything after #.');
            return self::FAILURE;
        }

        try {
            $research->storeAccessToken($accessToken, isset($params['expires_in']) ? (int) $params['expires_in'] : null);
        } catch (Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        $this->info('Google Search Console connected. Access token stored securely in storage/app.');

        return self::SUCCESS;
    }

    protected function parseCallbackParameters(string $callbackUrl): array
    {
        $parts = parse_url($callbackUrl);
        if (! is_array($parts)) {
            return [];
        }

        parse_str((string) ($parts['query'] ?? ''), $query);
        parse_str((string) ($parts['fragment'] ?? ''), $fragment);

        return array_merge($query, $fragment);
    }
}
