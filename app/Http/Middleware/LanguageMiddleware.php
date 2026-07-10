<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // $allowedLangs = config('language.allowed_languages');
        // $locale = $request->segment(1);
        // // dd($request->segment(1));
        // // If the first segment is not a valid language, redirect with locale
        // if (!in_array($locale, $allowedLangs)) {
        //     App::setlocale('en');
        //     // return redirect($request->getPathInfo(), 301);
        // }else{
        //     App::setlocale($locale);
        // }

        // $originalUrl = $request->getRequestUri();
        // $lowercaseUrl = strtolower($originalUrl);
        // if ($originalUrl !== $lowercaseUrl) {
        //     return redirect($lowercaseUrl, 301); // Permanent Redirect (SEO friendly)
        // }

        return $next($request);
    }
}
