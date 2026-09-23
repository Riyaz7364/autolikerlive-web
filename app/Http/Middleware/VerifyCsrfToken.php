<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        "/facebook/process-token",
        "/app/facebook/process-token",
        "all-messages",
        // Guest live-chat APIs authenticate via per-conversation guest_token
        // (bearer secret in body), so session CSRF adds nothing. Exempting also
        // keeps the widget working behind Cloudflare-cached pages.
        "api/chat/*",

    ];
}
