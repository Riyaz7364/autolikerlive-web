<?php

namespace Tests\Feature;

use App\Services\NetShort\NetShortEncoder;
use App\Services\SitemapBuilder;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EpisodeDownloadTest extends TestCase
{
    private ?string $fakePlayUrl = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(VerifyCsrfToken::class);

        // HARD GUARANTEE: no live/datarefresh HTTP can happen in these tests.
        Http::preventStrayRequests();

        Http::fake(function ($req) {
            $url = $req->url();
            if (str_contains($url, '/auth/login')) {
                return $this->enc(['code' => 200, 'data' => [
                    'loginUser' => ['userId' => '9'], 'token' => 'web-jwt', 'timeout' => 604799,
                ]]);
            }
            if (str_contains($url, 'app_link_startV2')) {
                return $this->enc(['code' => 200, 'data' => [
                    'shortPlayId' => '2103784897595645954',
                    'umsAppShareLinkVo' => [
                        'shortPlayId' => '2103784897595645954',
                        'episodeId' => 'ep1', 'episodeNo' => 3, 'shortPlayName' => 'Demo Drama',
                    ],
                ]]);
            }
            if (str_contains($url, 'episode/detail_info')) {
                return $this->enc(['code' => 200, 'data' => ['episodeList' => [[
                    'episodeId' => 'ep1', 'episodeNo' => 3, 'playVoucher' => $this->fakePlayUrl ?? 'https://cdn/x.mp4',
                ]]]]);
            }

            throw new \Exception('Unexpected upstream call: '.$url);
        });
    }

    protected function enc(array $json)
    {
        $priv = NetShortEncoder::derToPem(config('netshort.app_priv'), 'PRIVATE KEY');
        $pub = openssl_pkey_get_details(openssl_pkey_get_private($priv))['key'];
        $key = random_bytes(32);
        $ct = openssl_encrypt(json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 'AES-256-ECB', $key, OPENSSL_RAW_DATA);
        openssl_public_encrypt(base64_encode($key), $env, $pub, OPENSSL_PKCS1_PADDING);

        return Http::response(base64_encode($ct), 200, ['encrypt-key' => base64_encode($env)]);
    }

    public function test_page_shows_the_form(): void
    {
        $this->get('/netshort-video-downloader')
            ->assertOk()
            ->assertSee('ReelSwipe Video Downloader', false)
            ->assertSee('NetShort share link', false)
            ->assertSee('Find video', false)
            ->assertSee('nsx-progress-dialog', false);
    }

    public function test_encoded_hls_url_is_decoded_into_the_form_for_manual_submission(): void
    {
        $source = 'https://zshipricf.farsunpteltd.com/playlet-hls/hls_1787127898_12_73978.m3u8?verify=1793539135-RB4uEVDdgXAod2Skj9ll%2Fjx1UTzkkfTb2vZIsjykRFw%3D';
        $encodedSource = 'aHR0cHM6Ly96c2hpcHJpY2YuZmFyc3VucHRlbHRkLmNvbS9wbGF5bGV0LWhscy9obHNfMTc4NzEyNzg5OF8xMl83Mzk3OC5tM3U4P3ZlcmlmeT0xNzkzNTM5MTM1LVJCNHVFVkRkZ1hBb2QyU2tqOWxsJTJGangxVVR6a2tmVGIydlpJc2p5a1JGdyUzRA';

        $this->get('/netshort-video-downloader?url='.$encodedSource)
            ->assertOk()
            ->assertSee('value="'.$encodedSource.'"', false)
            ->assertSee('Find video', false)
            ->assertDontSee($source, false)
            ->assertDontSee('id="nsx-result"', false);
    }

    public function test_finding_video_converts_and_caches_mp4_before_showing_download(): void
    {
        config(['cache.default' => 'array']);
        Cache::store('array')->flush();

        $fakeFfmpeg = $this->fakeFfmpeg();

        $source = 'https://zshipricf.farsunpteltd.com/playlet-hls/hls_1787127898_12_73978.m3u8?verify=1793539135-RB4uEVDdgXAod2Skj9ll%2Fjx1UTzkkfTb2vZIsjykRFw%3D';
        $encodedSource = 'aHR0cHM6Ly96c2hpcHJpY2YuZmFyc3VucHRlbHRkLmNvbS9wbGF5bGV0LWhscy9obHNfMTc4NzEyNzg5OF8xMl83Mzk3OC5tM3U4P3ZlcmlmeT0xNzkzNTM5MTM1LVJCNHVFVkRkZ1hBb2QyU2tqOWxsJTJGangxVVR6a2tmVGIydlpJc2p5a1JGdyUzRA';

        try {
            $response = $this->post('/netshort-video-downloader', ['url' => $encodedSource])
                ->assertOk()
                ->assertSee('Your video is ready', false)
                ->assertSee('nsx-download-dialog', false)
                ->assertSee('Download MP4', false)
                ->assertSee('cache=', false)
                ->assertSee('value="'.$encodedSource.'"', false)
                ->assertDontSee('value="'.e($source).'"', false);

            $result = $response->viewData('result');
            $downloadUrl = $result['dl']['720p'];
            parse_str((string) parse_url($downloadUrl, PHP_URL_QUERY), $query);
            $cacheKey = 'reelswipe:download:'.$query['cache'];
            $cachedFile = Cache::get($cacheKey);

            $this->assertIsString($cachedFile);
            $this->assertFileExists($cachedFile);

            $this->get($downloadUrl)
                ->assertOk()
                ->assertHeader('content-type', 'video/mp4')
                ->assertStreamedContent('cached-mp4-fixture');

            $this->assertFileDoesNotExist($cachedFile);
            $this->assertFalse(Cache::has($cacheKey));
        } finally {
            @unlink($fakeFfmpeg);
        }
    }

    public function test_encoded_netshort_mp4_source_is_converted_and_cached_for_download(): void
    {
        config(['cache.default' => 'array']);
        Cache::store('array')->flush();

        $fakeFfmpeg = $this->fakeFfmpeg();
        $source = 'https://zshipricf.farsunpteltd.net/playlet-video/netshort-episode.mp4?verify=fixture';
        $encodedSource = rtrim(strtr(base64_encode($source), '+/', '-_'), '=');

        try {
            $this->get('/netshort-video-downloader?url='.$encodedSource)
                ->assertOk()
                ->assertSee('value="'.$encodedSource.'"', false)
                ->assertDontSee('This video source is not supported.', false);

            $response = $this->post('/netshort-video-downloader', ['url' => $encodedSource])
                ->assertOk()
                ->assertSee('Your video is ready', false)
                ->assertSee('Download MP4', false)
                ->assertSee('NetShort video', false);

            $result = $response->viewData('result');
            $downloadUrl = $result['dl']['720p'];
            parse_str((string) parse_url($downloadUrl, PHP_URL_QUERY), $query);
            $this->assertArrayHasKey('cache', $query, $downloadUrl);
            $cacheKey = 'reelswipe:download:'.$query['cache'];
            $cachedFile = Cache::get($cacheKey);

            $this->assertIsString($cachedFile);
            $this->assertFileExists($cachedFile);

            $this->get($downloadUrl)
                ->assertOk()
                ->assertHeader('content-type', 'video/mp4')
                ->assertStreamedContent('cached-mp4-fixture');

            $this->assertFileDoesNotExist($cachedFile);
            $this->assertFalse(Cache::has($cacheKey));
        } finally {
            @unlink($fakeFfmpeg);
        }
    }

    public function test_encoded_netshort_cdn_video_without_file_extension_is_converted_and_cached(): void
    {
        config(['cache.default' => 'array']);
        Cache::store('array')->flush();

        $fakeFfmpeg = $this->fakeFfmpeg();
        $source = 'https://ns-aws-cdn.netshort.com/signed-video?mime_type=video_mp4&auth_key=fixture';
        $encodedSource = rtrim(strtr(base64_encode($source), '+/', '-_'), '=');

        try {
            $this->get('/netshort-video-downloader?url='.$encodedSource)
                ->assertOk()
                ->assertSee('value="'.$encodedSource.'"', false)
                ->assertDontSee('This video source is not supported.', false);

            $response = $this->post('/netshort-video-downloader', ['url' => $encodedSource])
                ->assertOk()
                ->assertSee('Your video is ready', false)
                ->assertSee('Download MP4', false)
                ->assertDontSee('Could not fetch this episode right now.', false);

            $result = $response->viewData('result');
            $this->assertSame('MP4 video', $result['sourceFormat']);

            $downloadUrl = $result['dl']['720p'];
            parse_str((string) parse_url($downloadUrl, PHP_URL_QUERY), $query);
            $this->assertArrayHasKey('cache', $query, $downloadUrl);
            $cacheKey = 'reelswipe:download:'.$query['cache'];
            $cachedFile = Cache::get($cacheKey);

            $this->assertIsString($cachedFile);
            $this->assertFileExists($cachedFile);

            $this->get($downloadUrl)
                ->assertOk()
                ->assertHeader('content-type', 'video/mp4')
                ->assertStreamedContent('cached-mp4-fixture');

            $this->assertFileDoesNotExist($cachedFile);
            $this->assertFalse(Cache::has($cacheKey));
        } finally {
            @unlink($fakeFfmpeg);
        }
    }

    public function test_netshort_share_link_converts_hls_results_before_showing_download(): void
    {
        config(['cache.default' => 'array']);
        Cache::store('array')->flush();

        $fakeFfmpeg = $this->fakeFfmpeg();
        $source = 'https://zshipricf.farsunpteltd.net/playlet-hls/netshort-episode.m3u8?verify=fixture';
        $this->fakePlayUrl = $source;

        try {
            $response = $this->post('/netshort-video-downloader', [
                'url' => 'https://netshort.onelink.me/7xW2?deep_link_value=534be4a28d504a9ca1265cb51dc064c7',
            ])
                ->assertOk()
                ->assertSee('Your video is ready', false)
                ->assertSee('Download MP4', false)
                ->assertSee('Demo Drama', false);

            $result = $response->viewData('result');
            $this->assertSame(3, $result['episodeNo']);

            $downloadUrl = $result['dl']['720p'];
            parse_str((string) parse_url($downloadUrl, PHP_URL_QUERY), $query);
            $this->assertArrayHasKey('cache', $query, $downloadUrl);
            $cacheKey = 'reelswipe:download:'.$query['cache'];
            $cachedFile = Cache::get($cacheKey);

            $this->assertIsString($cachedFile);
            $this->assertFileExists($cachedFile);

            $this->get($downloadUrl)
                ->assertOk()
                ->assertHeader('content-type', 'video/mp4')
                ->assertStreamedContent('cached-mp4-fixture');

            $this->assertFileDoesNotExist($cachedFile);
            $this->assertFalse(Cache::has($cacheKey));
        } finally {
            @unlink($fakeFfmpeg);
        }
    }

    public function test_encoded_hls_url_from_an_unsupported_host_is_rejected(): void
    {
        $source = 'https://example.test/video.m3u8';
        $encodedSource = rtrim(strtr(base64_encode($source), '+/', '-_'), '=');

        $this->get('/netshort-video-downloader?url='.$encodedSource)
            ->assertOk()
            ->assertSee('This video source is not supported.', false)
            ->assertDontSee('hls=1', false);
    }

    public function test_encoded_mp4_url_from_an_unsupported_host_is_rejected(): void
    {
        $source = 'https://example.test/video.mp4';
        $encodedSource = rtrim(strtr(base64_encode($source), '+/', '-_'), '=');

        $this->get('/netshort-video-downloader?url='.$encodedSource)
            ->assertOk()
            ->assertSee('This video source is not supported.', false);
    }

    public function test_encoded_netshort_mime_type_url_from_a_lookalike_host_is_rejected(): void
    {
        $source = 'https://netshort.com.evil.example/video?mime_type=video_mp4';
        $encodedSource = rtrim(strtr(base64_encode($source), '+/', '-_'), '=');

        $this->get('/netshort-video-downloader?url='.$encodedSource)
            ->assertOk()
            ->assertSee('This video source is not supported.', false);
    }

    public function test_legacy_url_redirects_to_canonical(): void
    {
        $this->get('/episode-download')
            ->assertRedirect('/netshort-video-downloader');
    }

    public function test_share_link_returns_both_formats(): void
    {
        $res = $this->post('/netshort-video-downloader', [
            'url' => 'https://netshort.onelink.me/7xW2?deep_link_value=534be4a28d504a9ca1265cb51dc064c7',
        ])->assertOk();

        $res->assertSee('Demo Drama', false)
            ->assertSee('Download 720p', false)
            ->assertSee('Download 1080p', false)
            ->assertSee('https://cdn/x.mp4', false)
            // force-download proxy (saves file, no new tab)
            ->assertSee('/netshort-video-downloader/download', false)
            ->assertSee('nsx-phonevid', false)
            ->assertSee('autoplay', false);
    }

    public function test_legacy_post_still_works(): void
    {
        $this->post('/episode-download', [
            'url' => 'https://netshort.onelink.me/7xW2?deep_link_value=534be4a28d504a9ca1265cb51dc064c7',
        ])->assertOk()->assertSee('Download 720p', false);
    }

    public function test_bare_link_id_also_works(): void
    {
        $this->post('/netshort-video-downloader', ['linkId' => '534be4a28d504a9ca1265cb51dc064c7'])
            ->assertOk()
            ->assertSee('Download 720p', false);
    }

    public function test_download_requires_signature(): void
    {
        $this->get('/netshort-video-downloader/download?src=https://cdn/x.mp4&q=720p')
            ->assertForbidden();
    }

    public function test_download_rejects_bad_host(): void
    {
        $url = URL::temporarySignedRoute('netshort-video-downloader.download', now()->addMinutes(5), [
            'src' => 'https://localhost/x.mp4', 'q' => '720p', 'ep' => 1, 'name' => 'demo',
        ]);
        $this->get($url)->assertStatus(400);
    }

    public function test_find_video_shows_an_error_when_ffmpeg_is_unavailable(): void
    {
        config(['services.ffmpeg.binary' => '/missing/ffmpeg']);
        $source = 'https://zshipricf.farsunpteltd.com/playlet-hls/example.m3u8?verify=fixture';

        $this->post('/netshort-video-downloader', ['url' => $source])
            ->assertOk()
            ->assertSee('Could not prepare this video for download.', false)
            ->assertDontSee('nsx-download-dialog', false);
    }

    public function test_download_reports_when_prepared_video_cache_has_expired(): void
    {
        config(['cache.default' => 'array']);
        Cache::store('array')->flush();

        $url = URL::temporarySignedRoute('netshort-video-downloader.download', now()->addMinutes(5), [
            'cache' => str_repeat('a', 48),
            'name' => 'reelswipe-video',
        ]);

        $this->get($url)->assertStatus(410);
    }

    public function test_downloader_page_is_in_the_sitemap(): void
    {
        $this->assertContains('/netshort-video-downloader', SitemapBuilder::staticPaths());
        $this->assertStringContainsString(
            'https://www.autolikerlive.com/netshort-video-downloader',
            file_get_contents(public_path('sitemap.xml'))
        );
    }

    public function test_empty_input_fails_validation(): void
    {
        $this->post('/netshort-video-downloader', [])
            ->assertRedirect()
            ->assertSessionHasErrors(['url']);
    }

    public function test_encoder_round_trip(): void
    {
        $enc = NetShortEncoder::fromConfig()->encode(['searchCode' => 'wake']);
        $this->assertSame(344, strlen($enc['encryptKey']));
        $this->assertSame('{"searchCode":"wake"}', NetShortEncoder::decodeRequest($enc['aesKey'], $enc['body']));
    }

    private function fakeFfmpeg(): string
    {
        $fakeFfmpeg = tempnam(sys_get_temp_dir(), 'fake-ffmpeg-');
        if ($fakeFfmpeg === false) {
            $this->fail('Could not create the FFmpeg test executable.');
        }

        file_put_contents($fakeFfmpeg, <<<'PHP'
#!/usr/bin/env php
<?php
file_put_contents(end($argv), 'cached-mp4-fixture');
PHP);
        chmod($fakeFfmpeg, 0700);
        config(['services.ffmpeg.binary' => $fakeFfmpeg]);

        return $fakeFfmpeg;
    }
}
