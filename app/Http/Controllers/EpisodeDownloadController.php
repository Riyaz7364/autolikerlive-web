<?php

namespace App\Http\Controllers;

use App\Services\NetShort\NetShortShare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

/**
 * Public episode downloader: paste a NetShort share link -> get the
 * ORIGINAL live files in 720p + 1080p. No login, no DB.
 */
class EpisodeDownloadController extends Controller
{
    public function show(Request $request)
    {
        return view('episode-download', [
            'result' => null,
            'error' => null,
            'input' => (string) $request->query('url', ''),
        ]);
    }

    public function fetch(Request $request)
    {
        $request->validate([
            'url' => 'required_without:linkId|string|max:2000',
            'linkId' => 'required_without:url|string|max:64',
        ]);

        $input = (string) ($request->input('url') ?? $request->input('linkId'));

        try {
            $result = NetShortShare::fetchEpisode($input);
        } catch (\InvalidArgumentException $e) {
            return view('episode-download', ['result' => null, 'error' => $e->getMessage(), 'input' => $input]);
        } catch (\Throwable $e) {
            report($e);

            return view('episode-download', [
                'result' => null,
                'error' => 'Could not fetch this episode right now. Check the link and try again.',
                'input' => $input,
            ]);
        }

        if (! $result['files']['720p'] && ! $result['files']['1080p']) {
            return view('episode-download', [
                'result' => null,
                'error' => 'No playable file found for this episode (it may be locked).',
                'input' => $input,
            ]);
        }

        return view('episode-download', ['result' => $this->withDownloadLinks($result), 'error' => null, 'input' => $input]);
    }

    /**
     * Force-download proxy: streams the NetShort CDN file with
     * `Content-Disposition: attachment` so the browser SAVES the MP4
     * instead of opening it in a new tab.
     *
     * URL must be signed (generated right after fetch, 60 min expiry)
     * so the endpoint can't be abused as an open proxy / for SSRF.
     */
    public function download(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Download link expired. Please fetch the episode again.');
        }

        $src = (string) $request->query('src', '');
        $quality = $request->query('q') === '1080p' ? '1080p' : '720p';

        if (! preg_match('#^https://[^/\s]+/.+#i', $src)) {
            abort(400, 'Invalid file URL.');
        }

        $host = (string) parse_url($src, PHP_URL_HOST);
        $lowHost = strtolower($host);
        // Block localhost / metadata / non-public hosts (SSRF guard).
        if ($lowHost === '' || in_array($lowHost, ['localhost', 'metadata.google.internal'], true)
            || str_ends_with($lowHost, '.internal') || str_ends_with($lowHost, '.local')) {
            abort(400, 'Invalid file host.');
        }
        $ip = gethostbyname($host);
        if ($ip !== $host && ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            abort(400, 'Invalid file host.');
        }

        $ep = max(1, (int) $request->query('ep', 1));
        $rawName = (string) $request->query('name', 'netshort-episode');
        $slug = Str::slug(mb_substr($rawName, 0, 60)) ?: 'netshort-episode';
        $filename = "netshort-{$slug}-ep{$ep}-{$quality}.mp4";

        set_time_limit(0);
        ignore_user_abort(true);

        $ctx = stream_context_create(['http' => [
            'method' => 'GET',
            'timeout' => 120,
            'follow_location' => 1,
            'max_redirects' => 3,
            'header' => "User-Agent: Mozilla/5.0 (Linux; Android 14)\r\nReferer: https://www.autolikerlive.com/\r\nAccept: video/mp4,*/*\r\n",
        ]]);

        $in = @fopen($src, 'rb', false, $ctx);
        if ($in === false) {
            abort(502, 'Could not reach the video server. Try the direct link instead.');
        }

        return response()->streamDownload(function () use ($in) {
            while (! feof($in)) {
                echo fread($in, 8192);
                if (ob_get_level() > 0) {
                    ob_flush();
                }
                flush();
            }
            fclose($in);
        }, $filename, [
            'Content-Type' => 'video/mp4',
            'Cache-Control' => 'private, max-age=3600',
        ]);
    }

    /** Attach signed force-download URLs (60 min) to a fetch result. */
    protected function withDownloadLinks(array $result): array
    {
        $dl = [];
        foreach (['720p', '1080p'] as $q) {
            $src = $result['files'][$q] ?? null;
            $dl[$q] = $src ? URL::temporarySignedRoute(
                'netshort-video-downloader.download',
                now()->addMinutes(60),
                ['src' => $src, 'q' => $q, 'ep' => $result['episodeNo'] ?? 1, 'name' => $result['name'] ?? 'episode']
            ) : null;
        }
        $result['dl'] = $dl;

        return $result;
    }
}
