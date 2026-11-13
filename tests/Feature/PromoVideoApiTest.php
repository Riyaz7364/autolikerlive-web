<?php

namespace Tests\Feature;

use App\Support\PromoVideos;
use Tests\TestCase;

class PromoVideoApiTest extends TestCase
{
    private string $filename;

    protected function setUp(): void
    {
        parent::setUp();

        $this->filename = 'promo-api-test-'.bin2hex(random_bytes(6)).'.mp4';
        file_put_contents(PromoVideos::directory().'/'.$this->filename, 'fake video');
    }

    protected function tearDown(): void
    {
        $path = PromoVideos::directory().'/'.$this->filename;

        if (is_file($path)) {
            unlink($path);
        }

        parent::tearDown();
    }

    public function test_promo_video_api_returns_a_playable_video(): void
    {
        $response = $this->getJson(route('api.promo-video'));

        $response->assertOk();
        $response->assertJsonStructure(['url', 'link']);
        $this->assertStringContainsString('/storage/promo_videos/', (string) $response->json('url'));
        $this->assertStringEndsWith('.mp4', (string) $response->json('url'));
    }
}
