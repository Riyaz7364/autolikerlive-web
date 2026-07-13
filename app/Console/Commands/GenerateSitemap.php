<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Listing;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature   = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml file';

    public function handle(): void
    {
        $domain  = 'https://www.autolikerlive.com';
        $sitemap = Sitemap::create();
        $seen    = new \stdClass();
        $seen->urls = [];

        Crawler::create()
            ->setCrawlObserver(
                new class ($sitemap, $domain, $seen) extends CrawlObserver {

                    public function __construct(
                        protected Sitemap $sitemap,
                        protected string  $domain,
                        protected object  $seen
                    ) {}

                    public function crawled(
                        UriInterface      $url,
                        ResponseInterface $response,
                        ?UriInterface     $foundOnUrl = null,
                        ?string           $linkText   = null
                    ): void {
                        if ($response->getStatusCode() !== 200) {
                            return;
                        }

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
                        $isHome = in_array($rawPath, ['/', '', '/blog']);

                        $canonical = "{$this->domain}{$path}";

                        if (isset($this->seen->urls[$canonical])) {
                            return;
                        }
                        $this->seen->urls[$canonical] = true;

                        $priority = $isHome ? 1.0 : 0.8;

                        $this->sitemap->add(
                            Url::create($canonical)
                                ->setLastModificationDate(now())
                                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                                ->setPriority($priority)
                        );
                    }

                    public function finishedCrawling(): void {}
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

        $this->line('Crawler finished. Adding database pages...');

        // Published games
        Game::where('status', 'published')->each(function (Game $game) use ($sitemap, $domain, $seen) {
            $url = "{$domain}/game/{$game->slug}";
            if (!isset($seen->urls[$url])) {
                $seen->urls[$url] = true;
                $sitemap->add(
                    Url::create($url)
                        ->setLastModificationDate($game->updated_at ?? $game->created_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.8)
                );
                $this->line("  + /game/{$game->slug}");
            }
        });

        // Listings
        Listing::select('name')->get()->each(function ($listing) use ($sitemap, $domain, $seen) {
            $slug = str_replace(' ', '-', strtolower($listing->name));
            $url = "{$domain}/{$slug}";
            if (!isset($seen->urls[$url])) {
                $seen->urls[$url] = true;
                $sitemap->add(
                    Url::create($url)
                        ->setLastModificationDate(now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.6)
                );
                $this->line("  + /{$slug}");
            }
        });

        // Tags
        Tag::select('name')->get()->each(function ($tag) use ($sitemap, $domain, $seen) {
            $slug = str_replace(' ', '-', strtolower($tag->name));
            $url = "{$domain}/{$slug}";
            if (!isset($seen->urls[$url])) {
                $seen->urls[$url] = true;
                $sitemap->add(
                    Url::create($url)
                        ->setLastModificationDate(now())
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.6)
                );
                $this->line("  + /{$slug}");
            }
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $prodPath = '../public_html/sitemap.xml';
        $prodDir  = dirname($prodPath);
        if (is_dir($prodDir)) {
            $sitemap->writeToFile($prodPath);
            $this->info("✔ Written to public/ and public_html/");
        } else {
            $this->info("✔ Written to public/ (public_html/ not found, skipped)");
        }
    }
}
