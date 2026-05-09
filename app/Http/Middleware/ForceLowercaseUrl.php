<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceLowercaseUrl {
    public function handle($request, Closure $next) {
        $uri = $request->getRequestUri();
        if (preg_match('/[A-Z]/', $uri) && !str_contains($uri, '/api/') && !str_contains($uri, '/webhook/') && !str_contains($uri, '/app/') && !str_contains($uri, '/message/') && !str_contains($uri, '/blog/')) {
            return redirect(strtolower($uri), 301);
        }
        return $next($request);
    }
}
