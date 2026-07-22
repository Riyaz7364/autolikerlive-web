<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacebookSetting;

class FacebookSettingsController extends Controller
{
    public function index()
    {
        $setting = FacebookSetting::firstOrCreate([], [
            'lsd' => '',
            'fb_cookie' => '',
        ]);

        return view('admin.facebook-settings', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'lsd' => 'nullable|string|max:255',
            'fb_cookie' => 'nullable|string',
        ]);

        $setting = FacebookSetting::firstOrCreate([], [
            'lsd' => '',
            'fb_cookie' => '',
        ]);

        $setting->update([
            'lsd' => $request->lsd,
            'fb_cookie' => $request->fb_cookie,
        ]);

        return redirect()->route('admin.facebook-settings')->with('success', 'Facebook settings updated successfully.');
    }
}
