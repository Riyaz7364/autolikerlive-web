<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Promotion videos shown by the video gate.
 *
 * Files live in storage/app/public/promo_videos. Each file can have its own
 * destination link, stored in the existing `ad_settings` key/value table as
 * `promo_video_link:<filename>` so no extra table is required.
 */
class PromoVideos
{
    public const LINK_PREFIX = 'promo_video_link:';

    /**
     * Absolute path to the promotion video directory.
     */
    public static function directory(): string
    {
        return storage_path('app/public/promo_videos');
    }

    /**
     * Video filenames found in the promotion video directory.
     *
     * @return array<int, string>
     */
    public static function filenames(): array
    {
        $files = glob(self::directory().'/*.mp4') ?: [];
        $filenames = array_map('basename', $files);
        sort($filenames, SORT_NATURAL | SORT_FLAG_CASE);

        return array_values($filenames);
    }

    /**
     * Every promotion video with its public URL and configured link.
     *
     * @return array<int, array{filename: string, url: string, link: ?string}>
     */
    public static function all(): array
    {
        $links = self::links();
        $videos = [];

        foreach (self::filenames() as $filename) {
            $videos[] = [
                'filename' => $filename,
                'url' => asset('storage/promo_videos/'.rawurlencode($filename)),
                'link' => $links[$filename] ?? null,
            ];
        }

        return $videos;
    }

    /**
     * A random promotion video, or nulls when the folder has no videos.
     *
     * @return array{url: ?string, link: ?string}
     */
    public static function random(): array
    {
        $videos = self::all();

        if ($videos === []) {
            return ['url' => null, 'link' => null];
        }

        $video = $videos[array_rand($videos)];

        return ['url' => $video['url'], 'link' => $video['link']];
    }

    /**
     * Configured links keyed by filename.
     *
     * @return array<string, string>
     */
    public static function links(): array
    {
        try {
            $rows = DB::table('ad_settings')
                ->where('key', 'like', self::LINK_PREFIX.'%')
                ->get(['key', 'value']);
        } catch (Throwable $e) {
            return [];
        }

        $links = [];

        foreach ($rows as $row) {
            $filename = substr((string) $row->key, strlen(self::LINK_PREFIX));
            $link = trim((string) ($row->value ?? ''));

            if ($filename !== '' && $link !== '') {
                $links[$filename] = $link;
            }
        }

        return $links;
    }

    /**
     * Persist links keyed by filename. Empty values remove the link.
     *
     * @param  array<string, string|null>  $links
     */
    public static function saveLinks(array $links): void
    {
        $allowed = array_flip(self::filenames());

        foreach ($links as $filename => $link) {
            if (! isset($allowed[$filename])) {
                continue;
            }

            $key = self::LINK_PREFIX.$filename;
            $link = trim((string) $link);

            if ($link === '') {
                DB::table('ad_settings')->where('key', $key)->delete();

                continue;
            }

            DB::table('ad_settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $link]
            );
        }
    }
}
