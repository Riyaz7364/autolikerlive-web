<?php

return [
    // Master switch for Google AdSense — set ADSENSE_ENABLED=false to hide
    // the AdSense library + all ad units site-wide (Core Web Vitals).
    // Overridable per network / per unit from the Admin Panel > Ads Manager.
    'adsense_enabled' => env('ADSENSE_ENABLED', true),

    // Master switch for Adsterra ads (banners, native, social, smart link).
    // Overridable per network / per unit from the Admin Panel > Ads Manager.
    'adsterra_enabled' => env('ADSTERRA_ENABLED', true),
];
