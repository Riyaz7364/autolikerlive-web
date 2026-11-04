<?php

namespace Tests\Feature;

use App\Services\SitemapBuilder;
use Tests\TestCase;

class FreeInstagramAutoViewsTest extends TestCase
{
    public function test_page_is_available_and_included_in_the_sitemap_paths(): void
    {
        $this->get(route('free-instagram-views'))
            ->assertOk()
            ->assertSee('Free Instagram Auto Views')
            ->assertSee('1,000 Free Views')
            ->assertSee('name="type" value="INSTA_VIEWS"', false)
            ->assertSee('action="' . route('free-instagram-views-post') . '"', false)
            ->assertSee('data-video-ad-gate', false)
            ->assertSee('Watch a video ad to continue');

        $this->assertContains('/free-instagram-views', SitemapBuilder::staticPaths());
        $this->assertStringContainsString(
            'https://www.autolikerlive.com/free-instagram-views',
            file_get_contents(public_path('sitemap.xml'))
        );
    }
}
