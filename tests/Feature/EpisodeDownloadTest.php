<?php

namespace Tests\Feature;

use App\Services\NetShort\NetShortEncoder;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EpisodeDownloadTest extends TestCase
{
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
                    'episodeId' => 'ep1', 'episodeNo' => 3, 'playVoucher' => 'https://cdn/x.mp4',
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
            ->assertSee('NetShort Video Downloader', false)
            ->assertSee('NetShort share link', false)
            ->assertSee('Download NetShort Video', false);
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
}
