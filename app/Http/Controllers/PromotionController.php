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
            'button_text' => 'Try it now',
            'emoji' => '📸',
            'badge_text' => 'NEW APP',
            'show_on_tiktok_views' => true,
            'show_on_tiktok_likes' => true,
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
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'show_on_tiktok_views' => 'nullable|boolean',
            'show_on_tiktok_likes' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['show_on_tiktok_views'] = $request->boolean('show_on_tiktok_views');
        $validated['show_on_tiktok_likes'] = $request->boolean('show_on_tiktok_likes');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

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
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'show_on_tiktok_views' => 'nullable|boolean',
            'show_on_tiktok_likes' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['show_on_tiktok_views'] = $request->boolean('show_on_tiktok_views');
        $validated['show_on_tiktok_likes'] = $request->boolean('show_on_tiktok_likes');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

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
