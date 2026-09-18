<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Listing;
use App\Models\Tag;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

/**
 * Builds sitemap.xml from LIVE data only (no crawling):
 * curated static routes + DB listings/tags/games + /blog URLs
 * verified alive right now. Dead and redirecting URLs are excluded
 * so Search Console stops churning on 404/redirect buckets.
 */
class SitemapBuilder
{
    /**
     * Static Laravel pages that genuinely return 200.
     * (No admin/editor/callback/utility/binary endpoints.)
     */
    public static function staticPaths(): array
    {
        return [
            '/',
            '/services',
            '/about',
            '/contact',
            '/faq',
            '/privacy',
            '/terms',
            '/returnpolicy',
            '/download',
            '/delete-account',
            '/temp-mail',
            '/sms-bomber',
            '/call-bomber',
            '/findmyfbid',
            '/youtube_thumbnail_extractor',
            '/free-tiktok-views',
            '/free-tiktok-likes',
            '/free-instagram-likes',
            '/free-tiktok-views-iframe',
            '/auto-liker-1000-likes',
            '/auto-liker-instagram',
            '/yolikers',
            '/djliker',
            '/machineliker',
            '/fbsub',
            '/instagram-comment-liker',
            '/session/login',
            '/create-qr',
        ];
    }

    public static function build(?callable $onProgress = null): Sitemap
    {
        $domain = rtrim(config('app.url', 'https://www.autolikerlive.com'), '/');
        $sitemap = Sitemap::create();
        $seen = [];

        $add = function (string $path, float $priority = 0.6, $lastmod = null) use (&$seen, $sitemap, $domain, $onProgress) {
            $path = '/' . ltrim(strtolower($path), '/');
            $url = $domain . ($path === '/' ? '' : $path);
            if (isset($seen[$url])) {
                return;
            }
            $seen[$url] = true;
            $sitemap->add(
                Url::create($url)
                    ->setLastModificationDate($lastmod ?? now())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority($priority)
            );
            if ($onProgress) {
                $onProgress($url);
            }
        };

        // 1) Static pages
        foreach (self::staticPaths() as $path) {
            $add($path, $path === '/' ? 1.0 : 0.8);
        }

        // 2) Listings + tags (each renders a 200 landing page)
        foreach (Listing::select('name')->get() as $listing) {
            $add(str_replace(' ', '-', $listing->name), 0.6);
        }
        foreach (Tag::select('name')->get() as $tag) {
            $add(str_replace(' ', '-', $tag->name), 0.6);
        }

        // 3) Published games
        foreach (Game::where('status', 'published')->get() as $game) {
            $add('game/' . $game->slug, 0.8, $game->updated_at ?? $game->created_at);
        }

        // 4) /blog URLs carried over ONLY if alive right now (direct 200, no redirect)
        foreach (self::liveBlogUrls($domain, $onProgress) as $blogUrl) {
            $path = parse_url($blogUrl, PHP_URL_PATH) ?? '/';
            $add($path, 0.5);
        }

        return $sitemap;
    }

    /**
     * Take /blog/* URLs from the previous sitemap and keep only the ones
     * returning HTTP 200 without redirects (checked concurrently).
     *
     * @return string[]
     */
    protected static function liveBlogUrls(string $domain, ?callable $onProgress = null): array
    {
        $old = @file_get_contents(public_path('sitemap.xml'));
        if (! $old) {
            return [];
        }
        preg_match_all('/<loc>([^<]*)/', $old, $m);
        $candidates = [];
        foreach (array_unique($m[1]) as $loc) {
            $path = parse_url($loc, PHP_URL_PATH) ?? '';
            if (str_starts_with(strtolower($path), '/blog/') && $path !== '/blog/') {
                $candidates[] = $domain . $path;
            }
        }
        // Also verify /blog/ itself
        $candidates[] = $domain . '/blog/';

        $alive = [];
        $mh = curl_multi_init();
        $handles = [];
        $queue = array_values($candidates);

        $fill = function () use (&$queue, &$handles, $mh) {
            while (count($handles) < 12 && $queue) {
                $url = array_shift($queue);
                $ch = curl_init($url);
                curl_setopt_array($ch, [
                    CURLOPT_NOBODY => true,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_CONNECTTIMEOUT => 5,
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_USERAGENT => 'autolikerlive-sitemap-builder',
                ]);
                curl_multi_add_handle($mh, $ch);
                $handles[(int) $ch] = ['handle' => $ch, 'url' => $url];
            }
        };

        $fill();
        do {
            curl_multi_exec($mh, $running);
            curl_multi_select($mh, 1.0);
            while ($info = curl_multi_info_read($mh)) {
                $ch = $info['handle'];
                $meta = $handles[(int) $ch];
                $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
                // Some servers reject HEAD (405) — those get a GET retry below
                if ($code === 200) {
                    $alive[] = $meta['url'];
                    if ($onProgress) {
                        $onProgress($meta['url'] . ' [blog: alive]');
                    }
                } elseif ($code === 405) {
                    $queue[] = $meta['url'] . '#GET';
                }
                curl_multi_remove_handle($mh, $ch);
                curl_close($ch);
                unset($handles[(int) $ch]);
            }
            // Retry 405s with GET
            foreach ($queue as $i => $q) {
                if (str_ends_with($q, '#GET')) {
                    unset($queue[$i]);
                    $url = substr($q, 0, -4);
                    $single = curl_init($url);
                    curl_setopt_array($single, [
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_FOLLOWLOCATION => false,
                        CURLOPT_CONNECTTIMEOUT => 5,
                        CURLOPT_TIMEOUT => 12,
                        CURLOPT_SSL_VERIFYPEER => true,
                        CURLOPT_RANGE => '0-0',
                        CURLOPT_USERAGENT => 'autolikerlive-sitemap-builder',
                    ]);
                    curl_exec($single);
                    if ((int) curl_getinfo($single, CURLINFO_HTTP_CODE) === 200) {
                        $alive[] = $url;
                    }
                    curl_close($single);
                }
            }
            $queue = array_values($queue);
            $fill();
        } while ($running || $handles);

        curl_multi_close($mh);

        return array_values(array_unique($alive));
    }
}
