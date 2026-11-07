<?php

namespace App\Services;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class FacebookShareUrlResolver
{
    public function resolve(string $url): string
    {
        $parts = parse_url($url);
        $path = $parts['path'] ?? '';

        if (! preg_match('#^/share(?:/|$)#i', $path)) {
            return $url;
        }

        if (! $this->isFacebookUrl($parts)) {
            throw new RuntimeException('Only Facebook share URLs can be resolved.');
        }

        $finalUrl = $url;

        try {
            for ($redirects = 0; $redirects <= 5; $redirects++) {
                $response = Http::connectTimeout(5)
                    ->timeout(15)
                    ->withOptions(['allow_redirects' => false])
                    ->get($finalUrl);

                if (! $response->redirect()) {
                    $response->throw();
                    if (! $response->successful()) {
                        throw new RuntimeException('Facebook returned an unsuccessful response.');
                    }
                    break;
                }

                if ($redirects === 5) {
                    throw new RuntimeException('Facebook share URL exceeded the redirect limit.');
                }

                $location = $response->header('Location');
                if ($location === '') {
                    throw new RuntimeException('Facebook returned a redirect without a destination.');
                }

                try {
                    $finalUrl = (string) UriResolver::resolve(new Uri($finalUrl), new Uri($location));
                } catch (\InvalidArgumentException $exception) {
                    throw new RuntimeException('Facebook returned an invalid redirect destination.', 0, $exception);
                }

                if (! $this->isFacebookUrl(parse_url($finalUrl))) {
                    throw new RuntimeException('Facebook redirected to an unsupported host.');
                }
            }
        } catch (ConnectionException|RequestException $exception) {
            throw new RuntimeException('Facebook share URL could not be resolved.', 0, $exception);
        }

        $finalParts = parse_url($finalUrl);

        if (strtolower(trim($finalParts['path'] ?? '', '/')) === 'login') {
            parse_str($finalParts['query'] ?? '', $query);
            $nextUrl = $query['next'] ?? '';

            if (is_string($nextUrl) && $nextUrl !== '') {
                if (str_starts_with($nextUrl, '/')) {
                    $nextUrl = 'https://www.facebook.com'.$nextUrl;
                }
                $finalUrl = $nextUrl;
                $finalParts = parse_url($finalUrl);
            }
        }

        if (preg_match('#^/share(?:/|$)#i', $finalParts['path'] ?? '')) {
            throw new RuntimeException('Facebook did not redirect the share URL to its destination.');
        }

        return $this->canonicalize($finalUrl);
    }

    public function canonicalize(string $url): string
    {
        $parts = parse_url($url);

        if (! $this->isFacebookUrl($parts) || empty($parts['path'])) {
            throw new RuntimeException('Facebook returned an invalid destination URL.');
        }

        if (strtolower(trim($parts['path'], '/')) === 'login') {
            throw new RuntimeException('Facebook did not provide a public destination URL.');
        }

        return strtolower($parts['scheme']).'://'.strtolower($parts['host']).$parts['path'];
    }

    private function isFacebookUrl(array|false $parts): bool
    {
        if (! is_array($parts) || ! isset($parts['scheme'], $parts['host'])) {
            return false;
        }

        $scheme = strtolower($parts['scheme']);
        $port = $parts['port'] ?? null;

        return in_array($scheme, ['http', 'https'], true)
            && ($port === null || ($scheme === 'https' && $port === 443) || ($scheme === 'http' && $port === 80))
            && $this->isFacebookHost($parts['host']);
    }

    private function isFacebookHost(string $host): bool
    {
        $host = strtolower(rtrim($host, '.'));

        return $host === 'facebook.com' || str_ends_with($host, '.facebook.com');
    }
}
