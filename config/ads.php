<?php

return [
    // Master switch for Google AdSense — set ADSENSE_ENABLED=false to hide
    // the AdSense library + all ad units site-wide (Core Web Vitals).
    // AdMaven placements are separate and NOT affected by this flag.
    'adsense_enabled' => env('ADSENSE_ENABLED', false),
];
