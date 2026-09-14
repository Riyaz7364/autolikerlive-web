<?php

use Illuminate\Support\Facades\Route;

// Consolidated duplicates: /privacy and /terms are canonical (see sitemap).
// Old long URLs 301 here to keep their link equity.
Route::get('/privacy-policy', function () {
    return redirect('/privacy', 301);
});

Route::get('/terms-of-service', function () {
    return redirect('/terms', 301);
});
