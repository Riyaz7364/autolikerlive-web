<?php

namespace App\Http\Controllers;

use App\Support\PromoVideos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PromoVideoController extends Controller
{
    public function index()
    {
        $videos = PromoVideos::all();
        $maxUploadMb = $this->maxUploadMegabytes();

        return view('admin.promo-videos', compact('videos', 'maxUploadMb'));
    }

    public function store(Request $request)
    {
        $maxUploadKb = $this->maxUploadKilobytes();

        $validated = $request->validate([
            'video' => ['required', 'file', 'mimes:mp4', 'max:'.$maxUploadKb],
            'link' => ['nullable', 'url:http,https', 'max:500'],
        ]);

        $directory = PromoVideos::directory();
        File::ensureDirectoryExists($directory, 0775, true);

        $originalName = pathinfo($request->file('video')->getClientOriginalName(), PATHINFO_FILENAME);
        $baseName = Str::limit(Str::slug($originalName) ?: 'promo-video', 80, '');
        $filename = $baseName.'-'.Str::lower(Str::random(8)).'.mp4';

        $request->file('video')->move($directory, $filename);

        if (! empty($validated['link'])) {
            PromoVideos::saveLinks([$filename => $validated['link']]);
        }

        return redirect()
            ->route('admin.promo-videos.index')
            ->with('success', 'Promotion video uploaded successfully.');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'links' => 'nullable|array',
            'links.*' => 'nullable|url:http,https|max:500',
        ]);

        PromoVideos::saveLinks($validated['links'] ?? []);

        return redirect()
            ->route('admin.promo-videos.index')
            ->with('success', 'Promotion video links updated successfully.');
    }

    private function maxUploadKilobytes(): int
    {
        $limit = min(
            $this->iniSize(ini_get('upload_max_filesize')),
            $this->iniSize(ini_get('post_max_size')),
            100 * 1024 * 1024
        );

        return max(1, (int) floor(max(1, $limit - 524288) / 1024));
    }

    private function maxUploadMegabytes(): int
    {
        return max(1, (int) floor($this->maxUploadKilobytes() / 1024));
    }

    private function iniSize($value): int
    {
        $value = trim((string) $value);

        if ($value === '' || $value === '-1') {
            return PHP_INT_MAX;
        }

        $unit = strtolower(substr($value, -1));
        $multiplier = match ($unit) {
            'g' => 1024 ** 3,
            'm' => 1024 ** 2,
            'k' => 1024,
            default => 1,
        };

        return (int) ((float) $value * $multiplier);
    }
}