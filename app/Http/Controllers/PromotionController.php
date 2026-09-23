<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::orderBy('sort_order')->orderByDesc('updated_at')->paginate(25);

        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $promotion = new Promotion([
            'button_text' => 'Install',
            'emoji' => '📸',
            'badge_text' => 'NEW APP',
            'theme' => 'default',
            'show_on_tiktok_views' => true,
            'show_on_tiktok_likes' => true,
            'show_on_fb_1000_likes' => false,
            'show_on_landing' => false,
            'show_on_homepage' => false,
            'show_on_tools' => false,
            'is_active' => true,
            'sort_order' => 0,
        ]);

        return view('admin.promotions.create', compact('promotion'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'badge_text' => 'nullable|string|max:50',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'button_text' => 'required|string|max:50',
            'button_url' => 'required|string|max:500',
            'emoji' => 'nullable|string|max:10',
            'image_url' => 'nullable|string|max:500',
            'theme' => 'nullable|in:default,fb,instagram',
            'short_name' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'show_on_tiktok_views' => 'nullable|boolean',
            'show_on_tiktok_likes' => 'nullable|boolean',
            'show_on_fb_1000_likes' => 'nullable|boolean',
            'show_on_landing' => 'nullable|boolean',
            'show_on_homepage' => 'nullable|boolean',
            'show_on_tools' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['show_on_tiktok_views'] = $request->boolean('show_on_tiktok_views');
        $validated['show_on_tiktok_likes'] = $request->boolean('show_on_tiktok_likes');
        $validated['show_on_fb_1000_likes'] = $request->boolean('show_on_fb_1000_likes');
        $validated['show_on_landing'] = $request->boolean('show_on_landing');
        $validated['show_on_homepage'] = $request->boolean('show_on_homepage');
        $validated['show_on_tools'] = $request->boolean('show_on_tools');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['theme'] = $validated['theme'] ?? 'default';

        $promotion = Promotion::create($validated);

        return redirect()->route('admin.promotions.index')->with('success', "Promotion '{$promotion->name}' created.");
    }

    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);

        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'badge_text' => 'nullable|string|max:50',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'button_text' => 'required|string|max:50',
            'button_url' => 'required|string|max:500',
            'emoji' => 'nullable|string|max:10',
            'image_url' => 'nullable|string|max:500',
            'theme' => 'nullable|in:default,fb,instagram',
            'short_name' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'show_on_tiktok_views' => 'nullable|boolean',
            'show_on_tiktok_likes' => 'nullable|boolean',
            'show_on_fb_1000_likes' => 'nullable|boolean',
            'show_on_landing' => 'nullable|boolean',
            'show_on_homepage' => 'nullable|boolean',
            'show_on_tools' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['show_on_tiktok_views'] = $request->boolean('show_on_tiktok_views');
        $validated['show_on_tiktok_likes'] = $request->boolean('show_on_tiktok_likes');
        $validated['show_on_fb_1000_likes'] = $request->boolean('show_on_fb_1000_likes');
        $validated['show_on_landing'] = $request->boolean('show_on_landing');
        $validated['show_on_homepage'] = $request->boolean('show_on_homepage');
        $validated['show_on_tools'] = $request->boolean('show_on_tools');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['theme'] = $validated['theme'] ?? 'default';

        $promotion->update($validated);

        return redirect()->route('admin.promotions.index')->with('success', "Promotion '{$promotion->name}' updated.");
    }

    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion deleted.');
    }

    public function toggle($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->update(['is_active' => ! $promotion->is_active]);

        return redirect()->route('admin.promotions.index')
            ->with('success', $promotion->is_active ? 'Promotion enabled.' : 'Promotion paused.');
    }
}
