<?php

namespace App\Support;

use App\Models\Game;
use App\Models\MetaImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MetaImages
{
    /**
     * Routes shown in the admin meta image manager.
     *
     * @return array<int, array{key: string, label: string, dynamic: bool}>
     */
    public static function pages(): array
    {
        return [
            ['key' => 'home', 'label' => 'Home page', 'dynamic' => false],
            ['key' => 'services', 'label' => 'Free tools / services', 'dynamic' => false],
            ['key' => 'free-instagram-likes', 'label' => 'Free Instagram Likes', 'dynamic' => false],
            ['key' => 'free-instagram-views', 'label' => 'Free Instagram Views', 'dynamic' => false],
            ['key' => 'free-tiktok-likes', 'label' => 'Free TikTok Likes', 'dynamic' => false],
            ['key' => 'free-tiktok-views', 'label' => 'Free TikTok Views', 'dynamic' => false],
            ['key' => 'findmyfbid', 'label' => 'Find My Facebook ID', 'dynamic' => false],
            ['key' => 'instagram-comment-liker', 'label' => 'Instagram Comment Liker', 'dynamic' => false],
            ['key' => 'sms-bomber', 'label' => 'SMS Bomber', 'dynamic' => false],
            ['key' => 'call-bomber', 'label' => 'Call Bomber', 'dynamic' => false],
            ['key' => 'temp-mail', 'label' => 'Temp Mail', 'dynamic' => false],
            ['key' => 'temp-mail-privacy', 'label' => 'Temp Mail Privacy Policy', 'dynamic' => false],
            ['key' => 'netshort-video-downloader', 'label' => 'NetShort Video Downloader', 'dynamic' => false],
            ['key' => 'fbsub', 'label' => 'FBSub', 'dynamic' => false],
            ['key' => 'auto-liker-1000-likes', 'label' => 'FB Auto Liker 1000 Likes', 'dynamic' => false],
            ['key' => 'auto-liker-instagram', 'label' => 'Instagram Auto Liker', 'dynamic' => false],
            ['key' => 'games', 'label' => 'Games (uses each game thumbnail)', 'dynamic' => true],
        ];
    }

    /**
     * Make sure every managed route has a row in the database.
     */
    public static function ensureRows(): void
    {
        try {
            foreach (self::pages() as $page) {
                $row = MetaImage::firstOrCreate(
                    ['key' => $page['key']],
                    [
                        'label' => $page['label'],
                        'image' => self::detectImage($page['key']),
                        'is_dynamic' => $page['dynamic'],
                    ]
                );

                if (! $row->image && ($detected = self::detectImage($page['key']))) {
                    $row->image = $detected;
                    $row->save();
                }
            }

            $directory = storage_path('app/public/meta-images');

            if (is_dir($directory)) {
                foreach (glob($directory . '/*') as $file) {
                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                    if (! is_file($file) || ! in_array($extension, ['webp', 'png', 'jpg', 'jpeg'], true)) {
                        continue;
                    }

                    $key = pathinfo($file, PATHINFO_FILENAME);

                    MetaImage::firstOrCreate(
                        ['key' => $key],
                        [
                            'label' => Str::headline($key),
                            'image' => 'meta-images/' . basename($file),
                            'is_dynamic' => false,
                        ]
                    );
                }
            }
        } catch (\Throwable $e) {
            // The table may not be migrated yet.
        }
    }

    /**
     * Resolve the best meta image for the current request.
     */
    public static function current(?string $fallback = null): string
    {
        $request = request();
        $key = self::keyForPath($request->path());

        if ($request->routeIs('game.show', 'game.shared')) {
            $key = 'games';
            $slug = $request->route('slug');

            if ($slug) {
                try {
                    $thumbnail = Game::query()->where('slug', $slug)->value('thumbnail');

                    if ($thumbnail) {
                        return self::url($thumbnail);
                    }
                } catch (\Throwable $e) {
                    // Fall through to the configured image.
                }
            }
        }

        $image = self::configured($key) ?: self::detectImage($key);

        if (! $image) {
            return $fallback ?: asset('images/graphic.webp');
        }

        return self::url($image);
    }

    /**
     * Convert a stored path or full URL into a public URL.
     */
    public static function url(?string $image): string
    {
        if (! $image) {
            return asset('images/graphic.webp');
        }

        if (Str::startsWith($image, ['http://', 'https://', '//'])) {
            return $image;
        }

        if (Str::startsWith($image, '/')) {
            return url($image);
        }

        return Storage::disk('public')->url($image);
    }

    /**
     * Match a request path to a meta image key, e.g. temp-mail/privacy.
     */
    public static function keyForPath(string $path): string
    {
        $path = trim($path, '/');

        return $path === '' ? 'home' : str_replace('/', '-', $path);
    }

    public static function detectImage(string $key): ?string
    {
        foreach (['webp', 'png', 'jpg', 'jpeg'] as $extension) {
            $relative = 'meta-images/' . $key . '.' . $extension;

            if (Storage::disk('public')->exists($relative)) {
                return $relative;
            }
        }

        return null;
    }

    protected static function configured(string $key): ?string
    {
        try {
            return MetaImage::query()->where('key', $key)->value('image') ?: null;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
