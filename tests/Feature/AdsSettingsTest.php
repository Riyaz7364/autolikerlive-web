<?php

namespace Tests\Feature;

use App\Support\Ads;
use Tests\TestCase;

class AdsSettingsTest extends TestCase
{
    public function test_ad_network_toggles_persist(): void
    {
        $this->assertTrue(Ads::networkEnabled('adsense'));
        $this->assertTrue(Ads::networkEnabled('adsterra'));

        Ads::update(['adsense_enabled' => false]);
        $this->assertFalse(Ads::networkEnabled('adsense'));

        Ads::update(['adsense_enabled' => true]);
        $this->assertTrue(Ads::networkEnabled('adsense'));

        Ads::update(['adsterra_enabled' => false]);
        $this->assertFalse(Ads::networkEnabled('adsterra'));

        Ads::update(['adsterra_enabled' => true]);
        $this->assertTrue(Ads::networkEnabled('adsterra'));
    }

    public function test_ad_units_toggle_persist(): void
    {
        $this->assertTrue(Ads::unitEnabled('adsterra_banner'));
        $this->assertTrue(Ads::unitEnabled('adsense_leaderboard'));

        Ads::update(['adsterra_banner' => false]);
        $this->assertFalse(Ads::unitEnabled('adsterra_banner'));

        Ads::update(['adsense_leaderboard' => false]);
        $this->assertFalse(Ads::unitEnabled('adsense_leaderboard'));
    }

    public function test_admin_ads_update_route_persists_network_toggle(): void
    {
        $adminKey = (string) config('admin.secret_key');

        $response = $this->put(route('admin.ads.update') . '?admin_key=' . urlencode($adminKey), [
            'adsense_enabled' => '1',
            'adsterra_enabled' => '1',
        ]);

        $response->assertRedirect(route('admin.ads.index'));

        $this->assertTrue(Ads::networkEnabled('adsense'));
        $this->assertTrue(Ads::networkEnabled('adsterra'));
    }

    public function test_admin_ads_page_renders_with_auto_ads_unit(): void
    {
        $response = $this->get(route('admin.ads.index') . '?admin_key=' . urlencode((string) config('admin.secret_key')));

        $response->assertOk();
        $response->assertSee('Google Auto Ads');
        $response->assertSee('Adsterra');
        $response->assertSee('name="adsense_enabled"', false);
        $response->assertSee('name="adsterra_enabled"', false);
        $response->assertSee('name="adsterra_banner"', false);
    }
}
