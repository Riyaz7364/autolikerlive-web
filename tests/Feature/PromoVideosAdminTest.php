<?php

namespace Tests\Feature;

use App\Support\PromoVideos;
use Tests\TestCase;

class PromoVideosAdminTest extends TestCase
{
    private string $filename;

    protected function setUp(): void
    {
        parent::setUp();

        $this->filename = 'promo-test-' . bin2hex(random_bytes(6)) . '.mp4';
        file_put_contents(PromoVideos::directory() . '/' . $this->filename, 'fake video');
    }

    protected function tearDown(): void
    {
        $path = PromoVideos::directory() . '/' . $this->filename;

        if (is_file($path)) {
            unlink($path);
        }

        parent::tearDown();
    }

    public function test_admin_promo_videos_page_lists_videos_and_link_fields(): void
    {
        $response = $this->get(
            route('admin.promo-videos.index') . '?admin_key=' . urlencode((string) config('admin.secret_key'))
        );

        $response->assertOk();
        $response->assertSee($this->filename);
        $response->assertSee('name="links[' . $this->filename . ']"', false);
    }

    public function test_admin_can_save_a_different_link_per_video(): void
    {
        $link = 'https://example.com/offer?id=42';

        $response = $this->put(
            route('admin.promo-videos.update') . '?admin_key=' . urlencode((string) config('admin.secret_key')),
            ['links' => [$this->filename => $link]]
        );

        $response->assertRedirect(route('admin.promo-videos.index'));

        $this->assertSame($link, PromoVideos::links()[$this->filename] ?? null);
        $this->assertDatabaseHas('ad_settings', [
            'key' => PromoVideos::LINK_PREFIX . $this->filename,
            'value' => $link,
        ]);
    }

    public function test_invalid_links_are_rejected(): void
    {
        $response = $this->put(
            route('admin.promo-videos.update') . '?admin_key=' . urlencode((string) config('admin.secret_key')),
            ['links' => [$this->filename => 'javascript:alert(1)']]
        );

        $response->assertSessionHasErrors();
        $this->assertArrayNotHasKey($this->filename, PromoVideos::links());
    }

    public function test_video_gate_renders_the_configured_link_for_the_selected_video(): void
    {
        $links = [];

        foreach (PromoVideos::filenames() as $filename) {
            $links[$filename] = 'https://example.com/promo/' . rawurlencode($filename);
        }

        PromoVideos::saveLinks($links);

        $html = view('components.ads.video-gate', ['mode' => 'forms'])->render();

        $this->assertMatchesRegularExpression('/var promoVideoLink = ([^\n]+);/', $html);
        preg_match('/var promoVideoLink = ([^\n]+);/', $html, $matches);
        $link = json_decode($matches[1], true);

        $this->assertIsString($link);
        $this->assertStringStartsWith('https://example.com/promo/', $link);
    }
}