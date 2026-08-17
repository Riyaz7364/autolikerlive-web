<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $adminKey = config('admin.secret_key');

        if ($request->session()->get('admin_auth') === $adminKey) {
            return $next($request);
        }

        if ($request->query('admin_key') === $adminKey) {
            $request->session()->put('admin_auth', $adminKey);
            return $next($request);
        }

        if ($request->isMethod('post') && $request->input('admin_key') === $adminKey) {
            $request->session()->put('admin_auth', $adminKey);
            return $next($request);
        }

        abort(403, 'Unauthorized. Admin access required.');
    }
}
