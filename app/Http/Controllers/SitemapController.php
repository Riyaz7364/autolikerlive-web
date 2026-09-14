<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function createSitemap(){

        if (function_exists('set_time_limit')) {
            set_time_limit(0);
        }

        // Built from live data only — no crawling (see App\Services\SitemapBuilder)
        \App\Services\SitemapBuilder::build()->writeToFile(public_path('sitemap.xml'));

        echo ('Sitemap generated successfully!');
    }
}
