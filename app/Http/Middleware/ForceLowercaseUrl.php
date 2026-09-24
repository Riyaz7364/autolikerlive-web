<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceLowercaseUrl {
    public function handle($request, Closure $next) {
        // Lowercase the PATH only — never the query string. Query values
        // carry case-sensitive data (share hashes, FB redirect URLs with
        // %2F encodings, signed params). Mangling them caused pointless
        // 301s (e.g. /session/login?redirect=...%3A%2F%2F...) and can break
        // game shared links.
        $path = $request->getPathInfo();
        if (preg_match('/[A-Z]/', $path) && !str_contains($path, '/api/') && !str_contains($path, '/webhook/') && !str_contains($path, '/app/') && !str_contains($path, '/message/') && !str_contains($path, '/blog/') && !str_contains($path, '/livewire/') && !str_contains($path, '/editor/')) {
            $qs = $request->getQueryString();
            return redirect(strtolower($path) . ($qs ? '?' . $qs : ''), 301);
        }
        return $next($request);
    }
}
