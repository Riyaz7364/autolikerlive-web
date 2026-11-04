<?php

namespace Tests\Feature;

use Tests\TestCase;

class FacebookAutoLikerAdsTest extends TestCase
{
    public function test_ads_are_not_between_turnstile_and_reactions_and_follow_faq(): void
    {
        $response = $this->get(route('autoliker.facebook'));

        $response->assertOk();
        $html = $response->getContent();
        $turnstilePosition = strpos($html, 'id="cf-turnstile-box"');
        $reactionsPosition = strpos($html, 'class="reactions-row"');
        $faqPosition = strpos($html, 'Facebook Auto Liker &mdash; FAQ');

        $this->assertNotFalse($turnstilePosition);
        $this->assertNotFalse($reactionsPosition);
        $this->assertNotFalse($faqPosition);
        $this->assertFalse(
            str_contains(
                substr($html, $turnstilePosition, $reactionsPosition - $turnstilePosition),
                'adsbygoogle'
            )
        );

        $mobileAdPosition = strpos($html, 'class="ad-slot ad-leader show-mobile"');
        $inlineAdPosition = strpos($html, 'class="ad-slot ad-inline"');

        $this->assertNotFalse($mobileAdPosition);
        $this->assertNotFalse($inlineAdPosition);
        $this->assertGreaterThan($faqPosition, $mobileAdPosition);
        $this->assertGreaterThan($faqPosition, $inlineAdPosition);
    }
}
