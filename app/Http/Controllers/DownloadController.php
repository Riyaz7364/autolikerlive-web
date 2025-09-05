<?php
// app/Http/Controllers/DownloadController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    /**
     * Send the latest APK.
     */
    public function apk(): StreamedResponse
    {

        // Read info.json from the public folder
        $infoPath = public_path('info.json');

        $info = json_decode(file_get_contents($infoPath), true);
        $aplink = $info['link'];
        $fileName = $info['link'];

        // You can use $apkName, $fileName, $buildVersion as needed below

        //  ─── Where the file actually lives ────────────────────────────────
        $relativePath = 'builds/'.$aplink;          // storage/app/builds/…
        $disk         = Storage::disk('local');

        if (! $disk->exists($relativePath)) {
            abort(404, 'APK not found');
        }

        //  ─── Common headers (Cloudflare + browser cache for a year) ───────
        $headers = [
            'Content-Type'        => 'application/vnd.android.package-archive',
            'Content-Disposition' => 'attachment; '.$fileName,
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
