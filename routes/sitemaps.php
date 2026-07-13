<?php
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;


Route::get('sitemap-generator', [SitemapController::class, 'createSitemap']);
Route::get('sitemap.xml', function(){
    return response()->file(public_path('sitemap.xml'), [
        'Content-Type' => 'application/xml',
        'Accept' => 'application/xml',
    ]);
});
// Route::get('sitemap-en.xml', function(){
//     return response()->file(public_path('sitemap-en.xml'), [
//         'Content-Type' => 'application/xml',
//         'Accept' => 'application/xml',
//     ]);
// });

// Route::get('sitemap-bn.xml', function(){
//     return response()->file(public_path('sitemap-bn.xml'), [
//         'Content-Type' => 'application/xml',
//         'Accept' => 'application/xml',
//     ]);
// });

Route::get('robots.txt', function(){
    return response()->file(public_path('robots.txt'), [
        'Content-Type' => 'text/plain',
        'Accept' => 'text/plain',
    ]);
});
