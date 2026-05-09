<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Spatie\Crawler\Crawler;
use Illuminate\Support\Str;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ResponseInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class GenerateSitemap extends Command
{
    protected $signature   = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml file';

    public function handle(): void
    {
        $domain        = 'https://www.autolikerlive.com';
        $languages     = array_filter(config('language.allowed_languages'));
        $defaultLang   = config('app.fallback_locale', 'en');
        $manualPaths   = ['/blog', '/web-tools'];

        $sitemap = Sitemap::create();

        Crawler::create()
            ->setCrawlObserver(
                new class (
                    $sitemap,
                    $domain,
                    $manualPaths
                ) extends CrawlObserver {

                    public function __construct(
                        protected Sitemap $sitemap,
                        protected string  $domain,
                        protected array   $manualPaths
                    ) {}

                    public function crawled(
                        UriInterface      $url,
                        ResponseInterface $response,
                        ?UriInterface     $foundOnUrl = null,
                        ?string           $linkText   = null
                    ): void {
                        $rawPath = parse_url((string) $url, PHP_URL_PATH) ?? '/';

                        if (Str::startsWith(Str::lower($rawPath), '/blog/') && $rawPath !== '/blog/') {
                            $rawPath = Str::finish($rawPath, '/');
                        } else {
                            $rawPath = rtrim($rawPath, '/');
                        }

                        if (preg_match('/\.[a-z0-9]{2,5}$/i', $rawPath)) {
                            return;
                        }

                        $path = Str::of($rawPath)->start('/')->lower();
                        $isHome = $rawPath === '/' || $rawPath === '' || $rawPath === '/blog';

                        $canonical = "{$this->domain}{$path}";

                        static $seen = [];
                        if (isset($seen[$canonical])) {
                            return;
                        }
                        $seen[$canonical] = true;

                        $priority = $isHome ? 1.0 : 0.8;

                        $urlEntry = Url::create($canonical)
                            ->setLastModificationDate(now())
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
                            ->setPriority($priority);

                        $this->sitemap->add($urlEntry);
                    }

                    public function finishedCrawling(): void
                    {
                        // Will be saved from main handle()
                    }
                }
            )
            ->setCrawlProfile(
                new class ($domain) extends \Spatie\Crawler\CrawlProfiles\CrawlProfile {
                    public function __construct(protected string $domain) {}
                    public function shouldCrawl(UriInterface $url): bool
                    {
                        return str_starts_with((string) $url, $this->domain);
                    }
                }
            )
            ->startCrawling($domain);

        $sitemap->writeToFile('../public_html/sitemap.xml');
        $this->info("✔ sitemap.xml generated.");
    }
}
