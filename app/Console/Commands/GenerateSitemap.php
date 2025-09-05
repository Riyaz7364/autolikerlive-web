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
    protected $description = 'Generate individual language sitemap.xml files + master sitemap index';

    public function handle(): void
    {
        $domain        = 'https://www.autolikerlive.com';
        $languages     = array_filter(config('language.allowed_languages'));
        $defaultLang   = config('app.fallback_locale', 'en');
        $manualPaths   = ['/blog', '/web-tools'];

        $sitemapIndex = SitemapIndex::create();

        foreach ($languages as $lang) {
            $sitemap = Sitemap::create();

            Crawler::create()
                ->setCrawlObserver(
                    new class (
                        $sitemap,
                        $domain,
                        $languages,
                        $lang,
                        $defaultLang,
                        $manualPaths
                    ) extends CrawlObserver {

                        public function __construct(
                            protected Sitemap $sitemap,
                            protected string  $domain,
                            protected array   $languages,
                            protected string  $currentLang,
                            protected string  $defaultLang,
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

                            foreach ($this->languages as $lang) {
                                $prefix = '/' . strtolower($lang);
                                if (str_starts_with(strtolower($rawPath), $prefix)) {
                                    $rawPath = substr($rawPath, strlen($prefix));
                                    break;
                                }
                            }

                            $excludePrefix = collect($this->manualPaths)
                                ->contains(fn ($p) => Str::startsWith($rawPath, Str::of($p)->lower()));

                            $path = Str::of($rawPath)->start('/')->lower();
                            $isHome = $rawPath === '/' || $rawPath === '' || $rawPath === '/blog';

                            $canonical = match (true) {
                                $isHome                    => "{$this->domain}/" . ($this->currentLang === $this->defaultLang ? '' : $this->currentLang),
                                $excludePrefix             => "{$this->domain}{$path}",
                                $this->currentLang === $this->defaultLang => "{$this->domain}/{$this->defaultLang}{$path}",
                                default                    => "{$this->domain}/{$this->currentLang}{$path}"
                            };

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

                            $excludeAlt = collect($this->manualPaths)
                                ->map(fn ($p) => Str::of($p)->lower())
                                ->contains(fn ($p) => Str::startsWith($path, $p));

                            if (! $excludeAlt) {
                                $urlEntry->addAlternate(
                                    $isHome
                                        ? "{$this->domain}"
                                        : "{$this->domain}/{$this->defaultLang}{$path}",
                                    'x-default'
                                );

                                foreach ($this->languages as $lang) {
                                    $alt = match (true) {
                                        $lang === $this->defaultLang && $isHome => "{$this->domain}",
                                        $lang === $this->defaultLang             => "{$this->domain}/{$this->defaultLang}{$path}",
                                        $isHome                                  => "{$this->domain}/{$lang}/",
                                        default                                  => "{$this->domain}/{$lang}{$path}"
                                    };

                                    $urlEntry->addAlternate(Str::lower($alt), $lang);
                                }
                            }

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

            $fileName = "sitemap-{$lang}.xml";
            $filePath = public_path($fileName);
            $sitemap->writeToFile($filePath);
            $sitemapIndex->add("{$domain}/{$fileName}");
            $this->info("✔ sitemap-{$lang}.xml generated.");
        }

        // Save the index
        $sitemapIndex->writeToFile(public_path('sitemap.xml'));
        $this->info("✔ sitemap.xml index generated.");
    }
}
