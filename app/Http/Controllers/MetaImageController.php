<?php

namespace App\Http\Controllers;

use App\Models\MetaImage;
use App\Support\MetaImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MetaImageController extends Controller
{
    public function index()
    {
        MetaImages::ensureRows();

        $order = array_flip(array_column(MetaImages::pages(), 'key'));

        $images = MetaImage::orderBy('id')->get()
            ->sortBy(fn (MetaImage $image) => $order[$image->key] ?? 999)
            ->values();

        return view('admin.meta-images', compact('images'));
    }

    public function update(Request $request, MetaImage $metaImage)
    {
        $data = $request->validate([
            'image' => 'nullable|string|max:2048',
            'file' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('file')) {
            $old = $metaImage->image;
            $extension = $request->file('file')->extension() ?: 'webp';
            $path = $request->file('file')->storeAs(
                'meta-images',
                $metaImage->key . '-' . time() . '.' . $extension,
                'public'
            );

            if ($old && ! Str::startsWith($old, ['http://', 'https://', '/'])) {
                Storage::disk('public')->delete($old);
            }

            $metaImage->image = $path;
        } else {
            $metaImage->image = filled($data['image'] ?? null) ? trim($data['image']) : null;
        }

        $metaImage->save();

        return back()->with('success', "Meta image for /{$metaImage->key} updated.");
    }
}
