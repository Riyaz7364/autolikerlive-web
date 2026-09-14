<?php

namespace App\Console\Commands;

use App\Services\SitemapBuilder;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    protected $signature   = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml from live data (DB + curated routes + verified /blog URLs)';

    public function handle(): void
    {
        $sitemap = SitemapBuilder::build(fn ($url) => $this->line("  + {$url}"));

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $prodPath = '../public_html/sitemap.xml';
        $prodDir  = dirname($prodPath);
        if (is_dir($prodDir)) {
            $sitemap->writeToFile($prodPath);
            $this->info('✔ Written to public/ and public_html/');
        } else {
            $this->info('✔ Written to public/ (public_html/ not found, skipped)');
        }
    }
}
