<?php
// app/Http/Controllers/DownloadController.php

namespace App\Http\Controllers;

use App\Models\AppRelease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    /**
     * Send the latest APK.
     * - /download/apk            -> default app (autolikerlive, else first active, else info.json)
     * - /download/apk/{appName}  -> DB lookup by app_name
     */
    public function apk(Request $request, $appName = null): StreamedResponse
    {
        // 1) Try DB first
        if ($appName) {
            $app = AppRelease::where('app_name', AppRelease::normalizeKey($appName))->first();
        } else {
            $app = AppRelease::where('app_name', 'autolikerlive')->first()
                ?? AppRelease::where('is_active', true)->orderBy('id')->first();
        }

        if ($app && $app->apk_path) {
            $disk = Storage::disk('local');
            if ($disk->exists($app->apk_path)) {
                // Public name: DisplayName_releaseCode.apk (e.g. AutoLikerLive_7.apk)
                return $this->streamApk($disk, $app->apk_path, $app->download_filename);
            }
            // Explicit per-app request but file missing -> clear 404
            if ($appName) {
                abort(404, 'APK not found for app: ' . $app->app_name);
            }
            // Default route: fall through to legacy info.json below
        } elseif ($appName) {
            abort(404, "App '{$appName}' not found.");
        }

        // 2) Legacy fallback: public/info.json -> storage/app/builds/...
        $infoPath = public_path('info.json');
        if (! file_exists($infoPath)) {
            abort(404, $appName ? "App '{$appName}' not found." : 'APK not found');
        }

        $info = json_decode(file_get_contents($infoPath), true);
        $aplink = $info['link'] ?? null;
        if (! $aplink) {
            abort(404, 'APK not found');
        }
        $fileName = $aplink;

        //  ─── Where the file actually lives ────────────────────────────────
        $relativePath = 'builds/'.$aplink;          // storage/app/builds/…
        $disk         = Storage::disk('local');

        if (! $disk->exists($relativePath)) {
            abort(404, 'APK not found');
        }

        return $this->streamApk($disk, $relativePath, $fileName);
    }

    protected function streamApk($disk, string $relativePath, string $fileName): StreamedResponse
    {
        //  ─── Common headers (Cloudflare + browser cache for a year) ───────
        $headers = [
            'Content-Type'        => 'application/vnd.android.package-archive',
            'Content-Disposition' => 'attachment; filename="' . str_replace('"', '', $fileName) . '"',
            'Content-Length'      => $disk->size($relativePath),
            // max‑age one year + immutable → single visit, then always 0 ms TTFB
            'Cache-Control'       => 'public, max-age=31536000, immutable',
        ];

        //  ─── Otherwise stream through PHP (chunked, 8 KB) ─────────────────
        return response()->streamDownload(function () use ($disk, $relativePath) {
            $stream = $disk->readStream($relativePath);
            while (! feof($stream)) {
                echo fread($stream, 8192);
            }
            fclose($stream);
        }, $fileName, $headers);
    }
}
