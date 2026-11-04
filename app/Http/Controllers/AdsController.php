<?php

namespace App\Http\Controllers;

use App\Support\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    /**
     * Show the Ad Manager screen with every ad network + ad unit toggle.
     */
    public function index()
    {
        $ads = Ads::forAdmin();

        return view('admin.ads', compact('ads'));
    }

    /**
     * Update ad network master switches and ad unit toggles.
     *
     * Checkbox inputs only submit when checked, so unchecked boxes are stored
     * as `false` and checked ones (value="1") as `true`.
     */
    public function update(Request $request)
    {
        $values = [];

        foreach (Ads::settingKeys() as $key) {
            $values[$key] = $request->has($key) ? filter_var($request->input($key), FILTER_VALIDATE_BOOLEAN) : false;
        }

        Ads::update($values);

        return redirect()
            ->route('admin.ads.index')
            ->with('success', 'Advertisement settings updated successfully.');
    }
}
