<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DetectFakeTraffic
{
    public function handle(Request $req, Closure $next)
    {
        // $score = 0;
        // $ua = $req->header('User-Agent', '');
        // $referer = $req->header('Referer', '');
        // $secFetchSite = $req->header('Sec-Fetch-Site');
        // $origin = $req->header('Origin');
        // $parentUrl = $req->header('X-Parent-Url'); // from client-side JS
        // $realIp = $req->header('CF-Connecting-IP', $req->ip());

        // // Basic scoring
        // if (empty($referer)) $score += 1;
        // if (empty($secFetchSite)) $score += 2;
        // if (stripos($ua, 'curl') !== false || stripos($ua, 'bot') !== false) $score += 5;

        // // Capture all headers for inspection
        // $allHeaders = $req->headers->all();

        // Log::info('visit-check', [
        //     'ip' => $realIp,
        //     'ua' => $ua,
        //     'referer' => $referer,
        //     'origin' => $origin,
        //     'sec_fetch_site' => $secFetchSite,
        //     'parent_url' => $parentUrl,
        //     'score' => $score,
        //     'all_headers' => $allHeaders, // 👈 full header dump
        // ]);

        // if ($score >= 6) {
        //     return response('Access denied', 403);
        // }

        return $next($req);
    }

    protected function isDatacenterIp($ip)
    {
        // Add logic or external lookup if needed
        return false;
    }
}
