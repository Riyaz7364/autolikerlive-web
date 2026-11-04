<?php

namespace Tests\Feature;

use Tests\TestCase;

class BomberPagesAdsTest extends TestCase
{
    public function test_bomber_pages_do_not_serve_adsense_ads(): void
    {
        foreach (['sms-bomber', 'call-bomber'] as $page) {
            $response = $this->get(route($page));

            $response->assertOk();
            $response->assertDontSee('adsbygoogle');
            $response->assertDontSee('googlesyndication.com');
            $response->assertDontSee('ca-pub-8426510303593933');
        }
    }
}
