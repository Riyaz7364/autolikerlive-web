<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // NOTE: we deliberately do NOT call Broadcast::routes() — the default
        // /broadcasting/auth endpoint is session/CSRF-bound, which mobile
        // apps cannot use. The temp-mail API exposes its own channel
        // authorization endpoint instead:
        //   POST /api/tempmail/broadcasting/auth   (App Check required)
        // See \App\Http\Controllers\Api\TempMailApiController::broadcastAuth.

        Broadcast::resolveAuthenticatedUserUsing(function ($request) {
            // The temp-mail channel gates don't need a user; whatever
            // context is already stashed (or null) is passed on.
            return $request->attributes->get('appcheck.user') ?? $request->user();
        });

        require base_path('routes/channels.php');
    }
}
