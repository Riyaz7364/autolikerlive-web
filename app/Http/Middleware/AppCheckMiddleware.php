<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class AppCheckMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $appCheckToken = $request->header('X-Firebase-AppCheck');

        if (!$appCheckToken) {
            return response()->json(['error' => 'Invalid request taken'], 401);
        }

        try {
            $auth = (new Factory)->createAuth();
            $appCheck = (new Factory)->createAppCheck();
            $appCheck->verifyToken($appCheckToken); // Throws exception if invalid
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Unknown Invalid request taken'], 403);
        }

        return $next($request);
    }
}
