<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tell search engines not to index duplicate content served on
 * non-canonical hosts (mail/hostname/autoconfig subdomains,
 * alternate domains, etc.). The canonical host is www.autolikerlive.com.
 */
class NoIndexNonCanonicalHost
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->getHost() !== 'www.autolikerlive.com') {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        }

        return $response;
    }
}
