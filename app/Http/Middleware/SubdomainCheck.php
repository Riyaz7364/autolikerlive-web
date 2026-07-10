<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class SubdomainCheck
{
    public function handle(Request $request, Closure $next)
    {
        // Get the current subdomain
        $subdomain = $request->getHost();
        // dd($subdomain);
        // Check if the subdomain is correct and if the route exists for this subdomain
        if ($subdomain === 'tools.autolikerlive.com') {
            // dd($subdomain);

            // Check if the route exists in the application for the current URL
            // if (!Route::getRoutes()->match($request)->getName()) {
            //     // If the route does not exist, redirect to the main website
            //     return redirect('https://www.autolikerlive.com');
            // }
        }

        // Proceed with the request if all checks pass
        return $next($request);
    }
}
