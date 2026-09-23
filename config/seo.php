<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Renamed pages (301 redirects)
    |--------------------------------------------------------------------------
    | Old path (no slashes, lowercase) => new path. Used by the catch-all
    | listing route for pages that moved rather than disappeared.
    */
    'redirects' => [
        'privacy-policy' => 'privacy',
        'terms-of-service' => 'terms',
    ],

    /*
    |--------------------------------------------------------------------------
    | Retired archive/tag/date URLs (GSC 404 cleanup, 2026-09)
    |--------------------------------------------------------------------------
    | Keys are normalized: lowercase, dashes/underscores -> single space.
    | Old path => new path (301). Anything under tag//category//dated URLs
    | NOT listed here is served 410 (gone for good) instead of 404 so
    | Google drops it fast. Query strings (e.g. ?page=2) are ignored.
    */
    'tag_redirects' => [
        // findmyfbid cluster
        'findmyfbid' => '/findmyfbid',
        'find my fb id' => '/findmyfbid',
        'facebook id' => '/findmyfbid',
        // temp-mail cluster
        'temp mail' => '/temp-mail',
        'disposable mail' => '/temp-mail',
        'temporary email' => '/temp-mail',
        '10 mints mail' => '/temp-mail',
        'fakemailgenerator' => '/temp-mail',
        'email privacy' => '/temp-mail',
        'spam protection' => '/temp-mail',
        // auto-liker cluster
        'auto liker' => '/auto-liker-app',
        'auto likers' => '/auto-liker-app',
        'autoliker' => '/auto-liker-app',
        'auto liker live' => '/auto-liker-app',
        'auto liker benefits' => '/auto-liker-app',
        // instagram cluster
        'instagram auto liker' => '/auto-liker-instagram',
        'auto view' => '/auto-liker-instagram',
        'boost instagram likes' => '/auto-liker-instagram',
        'increase instagram engagement' => '/auto-liker-instagram',
        'instagram marketing' => '/auto-liker-instagram',
        'instagram safety' => '/auto-liker-instagram',
        'instagram creator tips' => '/auto-liker-instagram',
        // facebook cluster
        'facebook auto followers' => '/facebook-auto-followers',
        'fbsub' => '/fbsub',
        'facebook' => '/fbsub',
        'facebook page' => '/fbsub',
        'facebook profile' => '/fbsub',
        // misc live pages
        'tech' => '/tech',
        'tools' => '/services',
        'privacy' => '/privacy',
        'pc games' => '/games',
    ],

    'category_redirects' => [
        'tech' => '/tech',
        'fbsub' => '/fbsub',
        'auto liker' => '/auto-liker-app',
        'temp mail' => '/temp-mail',
        'ig liker' => '/auto-liker-instagram',
        'pc games' => '/games',
    ],

    'dated_redirects' => [
        'find-my-facebook-id' => '/findmyfbid',
        'what-is-temp-mail-why-and-how-to-use-it' => '/temp-mail',
        'fbsub-facebook-likes-hearts-followers-free' => '/fbsub',
        'how-to-easily-find-your-facebook-id-with-findmyfbid' => '/findmyfbid',
        'auto-liker-instagram-get-10-free-likes-on-instagram-posts-2025' => '/auto-liker-instagram',
        'get-free-tiktok-views-every-15-minutes-instant-real' => '/free-tiktok-views',
        'fb-and-ig-marketing-tools' => '/services',
    ],

];
