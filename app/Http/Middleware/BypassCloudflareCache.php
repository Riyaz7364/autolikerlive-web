<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Bypass Cloudflare cache for sensitive/dynamic paths.
 *
 * Cloudflare proxy is DNS-level, so true "no proxy" needs a grey-cloud
 * (DNS-only) hostname. On the proxied hostname this middleware tells
 * Cloudflare + browsers not to cache:
 * - /admin* (Laravel admin panel)
 * - /app/* (RajeLiker / AutoLiker Android WebView pages)
 * - /phpmineradmin* (phpMyAdmin, served by nginx alias outside Laravel)
 * - /session/* (login flow)
 *
 * Pairs with:
 * - nginx no-cache locations (same paths)
 * - Cloudflare Cache Rule "Bypass cache" for the same expressions
 *   (see scripts/cloudflare/)
 */
class BypassCloudflareCache
{
    /** @var string[] */
    protected array $prefixes = [
        '/admin',
        '/app/',
        '/app',
        '/phpmineradmin',
        '/session/',
        '/editor/games',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->shouldBypass($request)) {
            return $response;
        }

        // Origin-side kill switch: Cloudflare honors `Cache-Control: no-store`
        // and `CDN-Cache-Control: no-store` / `Cloudflare-CDN-Cache-Control`.
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        $response->headers->set('CDN-Cache-Control', 'no-store');
        $response->headers->set('Cloudflare-CDN-Cache-Control', 'no-store');

        // Never index admin / app internals.
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');

        return $response;
    }

    protected function shouldBypass(Request $request): bool
    {
        $path = '/' . ltrim($request->path(), '/');

        foreach ($this->prefixes as $prefix) {
            if ($path === $prefix || str_starts_with($path, rtrim($prefix, '/') . '/')) {
                return true;
            }
        }

        return false;
    }
}
