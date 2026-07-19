<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;

class ListingAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");
        }

        if ($request->filled('status')) {
            if ($request->status === 'linked') {
                $query->whereNotNull('post_id');
            } elseif ($request->status === 'unlinked') {
                $query->whereNull('post_id');
            }
        }

        $listings = $query->orderBy('name')->paginate(25);
        $total = Listing::count();
        $linked = Listing::whereNotNull('post_id')->count();
        $unlinked = $total - $linked;

        return view('admin.listings.index', compact('listings', 'total', 'linked', 'unlinked'));
    }

    public function create()
    {
        return view('admin.listings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:listings,name',
            'post_id' => 'nullable|integer',
            'type' => 'nullable|string|max:255',
        ]);

        Listing::create([
            'name' => $request->name,
            'post_id' => $request->post_id ?: null,
            'type' => $request->type ?: 'tool',
        ]);

        return redirect()->route('admin.listings.index')->with('success', 'Listing created successfully.');
    }

    public function edit($id)
    {
        $listing = Listing::findOrFail($id);
        return view('admin.listings.edit', compact('listing'));
    }

    public function update(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:listings,name,' . $listing->id,
            'post_id' => 'nullable|integer',
            'type' => 'nullable|string|max:255',
        ]);

        $listing->update([
            'name' => $request->name,
            'post_id' => $request->post_id ?: null,
            'type' => $request->type ?: 'tool',
        ]);

        return redirect()->route('admin.listings.index')->with('success', 'Listing updated successfully.');
    }

    public function destroy($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->delete();

        return redirect()->route('admin.listings.index')->with('success', 'Listing deleted successfully.');
    }
}
