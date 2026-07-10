<?php

namespace App\Http\Controllers;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Crawler\Crawler;
use Illuminate\Http\Request;
use Spatie\Sitemap\Tags\Url;
use Spatie\Crawler\CrawlProfiles\CrawlProfile;
use Psr\Http\Message\UriInterface;
class SitemapController extends Controller
{
    public function createSitemap(){

        $sitemap = Sitemap::create();

        SitemapGenerator::create('https://www.autolikerlive.com')
        // ->hasCrawled(function (Url $url) {
        //     if (preg_match('/\.[a-zA-Z0-9]+$/',$url->segment(1))) {
        //         return;
        //     }
        //     dd($url->segment(0));
        //     return $url;
        // })
        ->shouldCrawl(function (UriInterface $url) {
            // All pages will be crawled, except the contact page.
            // Links present on the contact page won't be added to the
            // sitemap unless they are present on a crawlable page.

            if (preg_match('/\.[a-zA-Z0-9]+$/', $url->getPath())) {
               return false;
            }
            return strpos($url->getPath(), '/contact') === false;
        })

            ->setLastModificationDate(now())
        //     ->setPriority(1.0)
        ->writeToFile(public_path('sitemap.xml'));
        // Write the sitemap to a file


        echo ('Sitemap generated successfully!');
    }
}
