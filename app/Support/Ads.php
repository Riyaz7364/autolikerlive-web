<?php

namespace App\Support;

use App\Models\AdSetting;

/**
 * Advertisement switches for the whole site.
 *
 * Two levels of control, both editable from the Unified Admin Panel
 * (Admin > Ads Manager):
 *
 *   1. Ad networks — `adsense_enabled` / `adsterra_enabled`
 *                    (master switch per ad network, falls back to the
 *                    `ADSENSE_ENABLED` / `ADSTERRA_ENABLED` env values).
 *
 *   2. Ad units — e.g. `adsense_leaderboard`, `adsterra_banner`,
 *                 `adsterra_banner_2`, `adsterra_native`, `adsterra_social`,
 *                 `adsterra_smart_link` (per unit override of the network).
 *
 * Values live in the `ad_settings` key/value table. When a key has never
 * been saved it falls back to the owning network master switch and finally to
 * the env-based default, so fresh installs keep the previous behaviour.
 */
class Ads
{
    public const NETWORK_ADSENSE = 'adsense';
    public const NETWORK_ADSTERRA = 'adsterra';

    /** Master switches (stored + admin toggleable). */
    public const KEY_ADSENSE_ENABLED = 'adsense_enabled';
    public const KEY_ADSTERRA_ENABLED = 'adsterra_enabled';

    /** AdSense units. */
    public const UNIT_ADSENSE_LEADERBOARD = 'adsense_leaderboard';
    public const UNIT_ADSENSE_MOBILE_BANNER = 'adsense_mobile_banner';
    public const UNIT_ADSENSE_SIDEBAR = 'adsense_sidebar';
    public const UNIT_ADSENSE_RESULT_RECTANGLE = 'adsense_result_rectangle';
    public const UNIT_ADSENSE_IN_ARTICLE = 'adsense_in_article';
    public const UNIT_ADSENSE_ANCHOR = 'adsense_anchor';
    public const UNIT_ADSENSE_AUTO_ADS = 'adsense_auto_ads';

    /** Adsterra units. */
    public const UNIT_ADSTERRA_BANNER = 'adsterra_banner';
    public const UNIT_ADSTERRA_BANNER_2 = 'adsterra_banner_2';
    public const UNIT_ADSTERRA_NATIVE = 'adsterra_native';
    public const UNIT_ADSTERRA_SOCIAL = 'adsterra_social';
    public const UNIT_ADSTERRA_SMART_LINK = 'adsterra_smart_link';

    /**
     * Ad networks known to the system (master switches).
     *
     * @return array<int, array{key: string, label: string, value: bool, description: string}>
     */
    public static function networks(): array
    {
        return [
            [
                'key' => self::NETWORK_ADSENSE,
                'label' => 'Google AdSense',
                'value' => self::networkEnabled(self::NETWORK_ADSENSE),
                'description' => 'Master switch for the Google AdSense library and all AdSense ad units.',
            ],
            [
                'key' => self::NETWORK_ADSTERRA,
                'label' => 'Adsterra',
                'value' => self::networkEnabled(self::NETWORK_ADSTERRA),
                'description' => 'Master switch for Adsterra ads (banners, native, social, smart link).',
            ],
        ];
    }

    /**
     * All known ad units with their resolved on/off state.
     *
     * @return array<int, array{key: string, label: string, network: string, value: bool, description: string}>
     */
    public static function units(): array
    {
        $units = [];

        foreach (self::allUnitDefinitions() as $unit) {
            $units[] = [
                'key' => $unit['key'],
                'label' => $unit['label'],
                'network' => $unit['network'],
                'value' => self::unitEnabled($unit['key']),
                'description' => $unit['description'],
            ];
        }

        return $units;
    }

    /**
     * True when the given ad network (master switch) is enabled.
     */
    public static function networkEnabled(string $network): bool
    {
        if ($network !== self::NETWORK_ADSENSE && $network !== self::NETWORK_ADSTERRA) {
            return false;
        }

        $value = self::readSetting($network . '_enabled');

        if ($value !== null) {
            return $value;
        }

        $default = $network === self::NETWORK_ADSENSE
            ? (bool) config('ads.adsense_enabled', true)
            : (bool) config('ads.adsterra_enabled', true);

        return $default;
    }

    /**
     * True when at least one AdSense feature needs the shared AdSense library.
     */
    public static function adsenseLibraryNeeded(): bool
    {
        if (!self::networkEnabled(self::NETWORK_ADSENSE)) {
            return false;
        }

        foreach ([
            self::UNIT_ADSENSE_AUTO_ADS,
            self::UNIT_ADSENSE_LEADERBOARD,
            self::UNIT_ADSENSE_MOBILE_BANNER,
            self::UNIT_ADSENSE_SIDEBAR,
            self::UNIT_ADSENSE_RESULT_RECTANGLE,
            self::UNIT_ADSENSE_IN_ARTICLE,
            self::UNIT_ADSENSE_ANCHOR,
        ] as $unit) {
            if (self::unitEnabled($unit)) {
                return true;
            }
        }

        return false;
    }

    /**
     * True when the given ad unit is enabled. Falls back to the owning
     * ad network master switch when no explicit unit override is saved.
     */
    public static function unitEnabled(string $unit): bool
    {
        $value = self::readSetting($unit);

        if ($value !== null) {
            return $value;
        }

        $network = str_contains($unit, '_') ? explode('_', $unit)[0] : $unit;

        if (!in_array($network, [self::NETWORK_ADSENSE, self::NETWORK_ADSTERRA], true)) {
            return false;
        }

        return self::networkEnabled($network);
    }

    /**
     * All known ad setting keys (master switches + ad units).
     *
     * @return array<int, string>
     */
    public static function settingKeys(): array
    {
        $keys = [
            self::KEY_ADSENSE_ENABLED,
            self::KEY_ADSTERRA_ENABLED,
        ];

        foreach (array_keys(self::allUnitDefinitions()) as $key) {
            $keys[] = $key;
        }

        return array_values(array_unique($keys));
    }

    /**
     * Persist ad on/off switches (booleans keyed by setting name).
     *
     * @param array<string, bool> $values
     */
    public static function update(array $values): void
    {
        foreach ($values as $key => $value) {
            $key = (string) $key;

            if (!in_array($key, self::settingKeys(), true)) {
                continue;
            }

            AdSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => filter_var($value, FILTER_VALIDATE_BOOLEAN)]
            );
        }
    }

    /**
     * Admin screen data: ad networks + ad units with resolved states.
     *
     * @return array{networks: array<int, array{key: string, label: string, value: bool, description: string}>, units: array<int, array{key: string, label: string, network: string, value: bool, description: string}>}
     */
    public static function forAdmin(): array
    {
        return [
            'networks' => self::networks(),
            'units' => self::units(),
        ];
    }

    /**
     * Raw unit definitions (key => definition).
     *
     * @return array<string, array{key: string, label: string, network: string, description: string}>
     */
    protected static function allUnitDefinitions(): array
    {
        return [
            // Google AdSense units
            self::UNIT_ADSENSE_LEADERBOARD => [
                'key' => self::UNIT_ADSENSE_LEADERBOARD,
                'label' => 'AdSense Leaderboard',
                'network' => self::NETWORK_ADSENSE,
                'description' => 'In-content leaderboard (728x90) on tools, landing pages and game cards.',
            ],
            self::UNIT_ADSENSE_MOBILE_BANNER => [
                'key' => self::UNIT_ADSENSE_MOBILE_BANNER,
                'label' => 'AdSense Mobile Banner',
                'network' => self::NETWORK_ADSENSE,
                'description' => 'Mobile banner (320x50) rendered at the bottom of the page.',
            ],
            self::UNIT_ADSENSE_SIDEBAR => [
                'key' => self::UNIT_ADSENSE_SIDEBAR,
                'label' => 'AdSense Sidebar',
                'network' => self::NETWORK_ADSENSE,
                'description' => 'Sidebar rectangle (300x250) shown beside content.',
            ],
            self::UNIT_ADSENSE_RESULT_RECTANGLE => [
                'key' => self::UNIT_ADSENSE_RESULT_RECTANGLE,
                'label' => 'AdSense Result Rectangle',
                'network' => self::NETWORK_ADSENSE,
                'description' => 'Result rectangle (300x250) shown below tool results and success messages.',
            ],
            self::UNIT_ADSENSE_IN_ARTICLE => [
                'key' => self::UNIT_ADSENSE_IN_ARTICLE,
                'label' => 'AdSense In-Article',
                'network' => self::NETWORK_ADSENSE,
                'description' => 'In-article fluid ad injected between content paragraphs.',
            ],
            self::UNIT_ADSENSE_ANCHOR => [
                'key' => self::UNIT_ADSENSE_ANCHOR,
                'label' => 'AdSense Anchor Ad',
                'network' => self::NETWORK_ADSENSE,
                'description' => 'Sticky scroll-triggered anchor ad (mobile, dismissible).',
            ],
            self::UNIT_ADSENSE_AUTO_ADS => [
                'key' => self::UNIT_ADSENSE_AUTO_ADS,
                'label' => 'Google Auto Ads',
                'network' => self::NETWORK_ADSENSE,
                'description' => 'Loads the AdSense library and enables Auto Ads. The library also loads automatically when any manual AdSense unit is active.',
            ],

            // Adsterra units
            self::UNIT_ADSTERRA_BANNER => [
                'key' => self::UNIT_ADSTERRA_BANNER,
                'label' => 'Adsterra Banner',
                'network' => self::NETWORK_ADSTERRA,
                'description' => 'Top banner ad (320x50) served by Adsterra.',
            ],
            self::UNIT_ADSTERRA_BANNER_2 => [
                'key' => self::UNIT_ADSTERRA_BANNER_2,
                'label' => 'Adsterra Banner 2',
                'network' => self::NETWORK_ADSTERRA,
                'description' => 'Medium rectangle banner (300x250) served by Adsterra.',
            ],
            self::UNIT_ADSTERRA_NATIVE => [
                'key' => self::UNIT_ADSTERRA_NATIVE,
                'label' => 'Adsterra Native Banner',
                'network' => self::NETWORK_ADSTERRA,
                'description' => 'In-read native ad served by Adsterra.',
            ],
            self::UNIT_ADSTERRA_SOCIAL => [
                'key' => self::UNIT_ADSTERRA_SOCIAL,
                'label' => 'Adsterra Social Ad',
                'network' => self::NETWORK_ADSTERRA,
                'description' => 'Social ad served by Adsterra — disturbing content, never placed on landing pages.',
            ],
            self::UNIT_ADSTERRA_SMART_LINK => [
                'key' => self::UNIT_ADSTERRA_SMART_LINK,
                'label' => 'Adsterra Smart Link',
                'network' => self::NETWORK_ADSTERRA,
                'description' => 'Smart Link opened in a popUnder automatically when a visitor submits a form.',
            ],
        ];
    }

    /**
     * Read a single setting from the `ad_settings` table.
     *
     * @return bool|null Resolved boolean or null when unset/unreadable.
     */
    protected static function readSetting(string $key): ?bool
    {
        try {
            $row = AdSetting::query()->where('key', $key)->first();

            if ($row === null) {
                return null;
            }

            $raw = strtolower(trim((string) ($row->value ?? '')));

            if ($raw === '') {
                return null;
            }

            return filter_var($raw, FILTER_VALIDATE_BOOLEAN);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
