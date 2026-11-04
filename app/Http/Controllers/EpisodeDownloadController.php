<?php

namespace App\Http\Controllers;

use App\Services\NetShort\NetShortShare;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Public video downloader for ReelSwipe HLS links and NetShort share links.
 */
class EpisodeDownloadController extends Controller
{
    public function show(Request $request): View
    {
        $encodedSource = (string) $request->query('url', '');
        $source = $this->decodeBase64UrlSource($encodedSource);

        if ($source !== null) {
            if (! $this->isAllowedVideoSource($source)) {
                return view('episode-download', [
                    'result' => null,
                    'error' => 'This video source is not supported.',
                    'input' => $encodedSource,
                ]);
            }

            return view('episode-download', [
                'result' => null,
                'error' => null,
                'input' => $encodedSource,
            ]);
        }

        return view('episode-download', [
            'result' => null,
            'error' => null,
            'input' => $encodedSource,
        ]);
    }

    public function fetch(Request $request): View
    {
        $request->validate([
            'url' => 'required_without:linkId|string|max:2000',
            'linkId' => 'required_without:url|string|max:64',
        ]);

        $input = trim((string) ($request->input('url') ?? $request->input('linkId')));
        $source = $this->decodeBase64UrlSource($input) ?? $input;

        if ($this->looksLikeVideoSource($source)) {
            if (! $this->isAllowedVideoSource($source)) {
                return view('episode-download', [
                    'result' => null,
                    'error' => 'This video source is not supported.',
                    'input' => $input,
                ]);
            }

            try {
                $result = $this->convertAndCacheVideo($source);
            } catch (\Throwable $exception) {
                report($exception);

                return view('episode-download', [
                    'result' => null,
                    'error' => 'Could not prepare this video for download. Please try again later.',
                    'input' => $input,
                ]);
            }

            return view('episode-download', [
                'result' => $result,
                'error' => null,
                'input' => $input,
            ]);
        }

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

        foreach (['720p', '1080p'] as $quality) {
            $resolvedSource = $result['files'][$quality] ?? null;
            if (! is_string($resolvedSource) || ! $this->looksLikeHlsSource($resolvedSource)) {
                continue;
            }

            if (! $this->isAllowedVideoSource($resolvedSource)) {
                return view('episode-download', [
                    'result' => null,
                    'error' => 'This video source is not supported.',
                    'input' => $input,
                ]);
            }

            try {
                $preparedResult = $this->convertAndCacheVideo($resolvedSource);
            } catch (\Throwable $exception) {
                report($exception);

                return view('episode-download', [
                    'result' => null,
                    'error' => 'Could not prepare this video for download. Please try again later.',
                    'input' => $input,
                ]);
            }

            $preparedResult['name'] = $result['name'] ?? 'NetShort video';
            $preparedResult['episodeNo'] = $result['episodeNo'];
            $preparedResult['episodeId'] = $result['episodeId'];

            return view('episode-download', [
                'result' => $preparedResult,
                'error' => null,
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
    public function download(Request $request): StreamedResponse
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Download link expired. Please fetch the episode again.');
        }

        $cacheToken = (string) $request->query('cache', '');
        if ($cacheToken !== '') {
            return $this->downloadCachedVideo($cacheToken);
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

    private function convertAndCacheVideo(string $source): array
    {
        $binary = (string) config('services.ffmpeg.binary', 'ffmpeg');
        if (! $this->isExecutableCommand($binary) || ! function_exists('proc_open')) {
            throw new \RuntimeException('MP4 conversion is unavailable because FFmpeg is not configured.');
        }

        $this->removeExpiredCachedVideoFiles();

        $outputPath = tempnam(sys_get_temp_dir(), 'reelswipe-');
        if ($outputPath === false) {
            throw new \RuntimeException('Could not prepare the video download.');
        }

        set_time_limit(0);
        ignore_user_abort(true);

        try {
            $this->convertVideoToMp4($source, $outputPath, $binary);
        } catch (\Throwable $exception) {
            $this->removeTemporaryFile($outputPath);

            throw $exception;
        }

        if (! is_file($outputPath) || filesize($outputPath) === 0) {
            $this->removeTemporaryFile($outputPath);

            throw new \RuntimeException('FFmpeg returned an empty MP4 file.');
        }

        $cacheToken = Str::random(48);
        $cacheKey = $this->cachedVideoKey($cacheToken);

        try {
            $stored = Cache::put($cacheKey, $outputPath, now()->addHour());
        } catch (\Throwable $exception) {
            $this->removeTemporaryFile($outputPath);

            throw $exception;
        }

        if (! $stored) {
            $this->removeTemporaryFile($outputPath);

            throw new \RuntimeException('Could not store the converted video in cache.');
        }

        $result = $this->preparedVideoResult($source);
        $result['dl'] = [
            '720p' => URL::temporarySignedRoute(
                'netshort-video-downloader.download',
                now()->addHour(),
                ['cache' => $cacheToken, 'name' => 'reelswipe-video']
            ),
            '1080p' => null,
        ];

        return $result;
    }

    private function downloadCachedVideo(string $cacheToken): StreamedResponse
    {
        if (! preg_match('/^[A-Za-z0-9]{48}$/D', $cacheToken)) {
            abort(404, 'This prepared video is no longer available.');
        }

        $outputPath = Cache::pull($this->cachedVideoKey($cacheToken));
        if (! is_string($outputPath) || ! is_file($outputPath)) {
            abort(410, 'This prepared video expired. Please prepare it again.');
        }

        return response()->streamDownload(function () use ($outputPath): void {
            try {
                if (readfile($outputPath) === false) {
                    throw new \RuntimeException('Could not read the cached MP4 file.');
                }
            } finally {
                $this->removeTemporaryFile($outputPath);
            }
        }, 'reelswipe-video.mp4', [
            'Content-Type' => 'video/mp4',
            'Cache-Control' => 'private, no-store',
        ]);
    }

    private function cachedVideoKey(string $cacheToken): string
    {
        return 'reelswipe:download:'.$cacheToken;
    }

    private function removeExpiredCachedVideoFiles(): void
    {
        $files = glob(sys_get_temp_dir().DIRECTORY_SEPARATOR.'reelswipe-*');
        if ($files === false) {
            return;
        }

        $expiry = now()->subHours(2)->getTimestamp();
        foreach ($files as $path) {
            $modifiedAt = is_file($path) ? filemtime($path) : false;
            if ($modifiedAt !== false && $modifiedAt < $expiry) {
                $this->removeTemporaryFile($path);
            }
        }
    }

    private function convertVideoToMp4(string $source, string $outputPath, string $binary): void
    {
        $command = [
            $binary,
            '-hide_banner',
            '-loglevel',
            'error',
            '-nostdin',
            '-protocol_whitelist',
            'https,tls,tcp,crypto',
            '-rw_timeout',
            '20000000',
            '-i',
            $source,
            '-map',
            '0:v:0',
            '-map',
            '0:a:0?',
            '-c',
            'copy',
            '-movflags',
            '+faststart',
            '-f',
            'mp4',
            '-y',
            $outputPath,
        ];
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $pipes = [];
        $process = proc_open($command, $descriptors, $pipes, null, null, ['bypass_shell' => true]);

        if (! is_resource($process)) {
            throw new \RuntimeException('Could not start the FFmpeg process.');
        }

        $exitCode = -1;
        $errorOutput = '';

        try {
            fclose($pipes[0]);
            stream_set_blocking($pipes[1], false);
            stream_set_blocking($pipes[2], false);

            $timeout = max(30, (int) config('services.ffmpeg.timeout', 600));
            $deadline = microtime(true) + $timeout;

            while (true) {
                $chunk = stream_get_contents($pipes[2]);
                if ($chunk !== false) {
                    $errorOutput = substr($errorOutput.$chunk, -8192);
                }

                $status = proc_get_status($process);
                if (! $status['running']) {
                    $exitCode = $status['exitcode'];
                    break;
                }

                if (microtime(true) >= $deadline) {
                    proc_terminate($process, 9);
                    throw new \RuntimeException('FFmpeg conversion timed out.');
                }

                usleep(100000);
            }

            $chunk = stream_get_contents($pipes[2]);
            if ($chunk !== false) {
                $errorOutput = substr($errorOutput.$chunk, -8192);
            }
        } finally {
            foreach ($pipes as $pipe) {
                if (is_resource($pipe)) {
                    fclose($pipe);
                }
            }

            $closeCode = proc_close($process);
            if ($exitCode < 0) {
                $exitCode = $closeCode;
            }
        }

        if ($exitCode !== 0) {
            throw new \RuntimeException('FFmpeg conversion failed: '.trim($errorOutput));
        }
    }

    private function isExecutableCommand(string $binary): bool
    {
        if ($binary === '') {
            return false;
        }

        if (str_contains($binary, DIRECTORY_SEPARATOR)) {
            return is_file($binary) && is_executable($binary);
        }

        foreach (explode(PATH_SEPARATOR, (string) getenv('PATH')) as $directory) {
            $path = rtrim($directory, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$binary;
            if (is_file($path) && is_executable($path)) {
                return true;
            }
        }

        return false;
    }

    private function removeTemporaryFile(string $path): void
    {
        if (is_file($path) && ! unlink($path)) {
            report(new \RuntimeException('Could not remove a temporary video file.'));
        }
    }

    private function decodeBase64UrlSource(string $encodedSource): ?string
    {
        if ($encodedSource === '' || strlen($encodedSource) > 10924
            || ! preg_match('/^[A-Za-z0-9_-]+$/D', $encodedSource)) {
            return null;
        }

        $decoded = base64_decode(
            strtr($encodedSource, '-_', '+/').str_repeat('=', (4 - strlen($encodedSource) % 4) % 4),
            true
        );

        if ($decoded === false || strlen($decoded) > 8192 || ! filter_var($decoded, FILTER_VALIDATE_URL)) {
            return null;
        }

        return $decoded;
    }

    private function looksLikeVideoSource(string $source): bool
    {
        $path = strtolower((string) parse_url($source, PHP_URL_PATH));
        $parts = parse_url($source);

        if (str_ends_with($path, '.m3u8') || str_ends_with($path, '.mp4')) {
            return true;
        }

        if (! is_array($parts) || ! $this->isNetShortCdnHost(strtolower((string) ($parts['host'] ?? '')))) {
            return false;
        }

        parse_str((string) ($parts['query'] ?? ''), $query);

        return in_array(strtolower((string) ($query['mime_type'] ?? '')), ['video_mp4', 'video/mp4'], true);
    }

    private function looksLikeHlsSource(string $source): bool
    {
        return str_ends_with(strtolower((string) parse_url($source, PHP_URL_PATH)), '.m3u8');
    }

    private function isAllowedVideoSource(string $source): bool
    {
        $parts = parse_url($source);
        if (! is_array($parts)
            || strtolower((string) ($parts['scheme'] ?? '')) !== 'https'
            || isset($parts['user'])
            || isset($parts['pass'])
            || (isset($parts['port']) && $parts['port'] !== 443)
            || ! $this->looksLikeVideoSource($source)) {
            return false;
        }

        $host = strtolower(rtrim((string) ($parts['host'] ?? ''), '.'));

        foreach (['farsunpteltd.com', 'farsunpteltd.net', 'netshort.com'] as $allowedDomain) {
            if ($host === $allowedDomain || str_ends_with($host, '.'.$allowedDomain)) {
                return true;
            }
        }

        return false;
    }

    private function isNetShortCdnHost(string $host): bool
    {
        return $host === 'netshort.com' || str_ends_with($host, '.netshort.com');
    }

    /**
     * @return array{name: string, episodeNo: int, episodeId: string, files: array{720p: string, 1080p: null}, hls: bool}
     */
    private function preparedVideoResult(string $source): array
    {
        $isHls = $this->looksLikeHlsSource($source);

        return [
            'name' => 'NetShort video',
            'episodeNo' => 1,
            'episodeId' => 'stream',
            'files' => ['720p' => $source, '1080p' => null],
            'hls' => $isHls,
            'prepared' => true,
            'sourceFormat' => $isHls ? 'HLS stream' : 'MP4 video',
        ];
    }

    /** Attach signed force-download URLs (60 min) to a fetch result. */
    protected function withDownloadLinks(array $result): array
    {
        $dl = [];
        foreach (['720p', '1080p'] as $q) {
            $src = $result['files'][$q] ?? null;
            $parameters = [
                'src' => $src,
                'q' => $q,
                'ep' => $result['episodeNo'] ?? 1,
                'name' => $result['name'] ?? 'episode',
            ];
            if ($result['hls'] ?? false) {
                $parameters['hls'] = '1';
            }
            $dl[$q] = $src ? URL::temporarySignedRoute(
                'netshort-video-downloader.download',
                now()->addMinutes(60),
                $parameters
            ) : null;
        }
        $result['dl'] = $dl;

        return $result;
    }
}
