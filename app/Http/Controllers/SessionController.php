<?php

namespace App\Http\Controllers;

use App\Models\GameSession;
use App\Services\FacebookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Storage;
class SessionController extends Controller
{
    protected FacebookService $fb;

    public function __construct(FacebookService $fb)
    {
        $this->fb = $fb;
    }

    public function loginPage()
    {
        return view('games.login');
    }

    public function loginFb(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fburl' => 'required|string'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $input = $request->input('fburl');

        $this->fb->resolveFBId($input);

        try {
            
            $fbId = $this->fb->id;
            $username = $this->fb->username;
            $name = $this->fb->name;
            if (!$fbId) {
                return back()->with('error', 'Could not find Facebook ID. Make sure the profile is public.');
            }
        

            $profilePic = $this->fb->getProfilePicUrl($fbId);

            $existing = GameSession::find($fbId);
            if ($existing) {
                $existing->update([
                    'name' => $name,
                    'username' => $username,
                    'profile_pic' => $profilePic,
                ]);
                cookie()->queue(cookie()->forever('game_session', $fbId));
                return redirect()->to($request->input('redirect', '/'))->with('success', 'Logged in successfully!');
            }

            GameSession::create([
                'id' => $fbId,
                'name' => $name,
                'username' => $username,
                'profile_pic' => $profilePic ?? '',
            ]);

            cookie()->queue(cookie()->forever('game_session', $fbId));

            return redirect()->to($request->input('redirect', '/'))->with('success', 'Logged in successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function loginManual(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $fullName = $request->input('name');

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('manual-avatars', 'public');
        }

        $id = $this->generateManualId();
        [$username] = $this->makeUniqueUsername($fullName);

        GameSession::create([
            'id' => $id,
            'name' => $fullName,
            'username' => $username,
            'profile_pic' => $imagePath ? \Illuminate\Support\Facades\Storage::disk('public')->url($imagePath) : '',
        ]);

        cookie()->queue(cookie()->forever('game_session', $id));

        return redirect()->to($request->input('redirect', '/'))->with('success', 'Logged in successfully!');
    }

    public function logout()
    {
        $id = request()->cookie('game_session');
        if ($id) {
            GameSession::destroy($id);
        }

        cookie()->queue(cookie()->forget('game_session'));

        return redirect('/')->with('success', 'Logged out.');
    }

    private function generateManualId(): string
    {
        $id = rand(10000, 99999);
        while (GameSession::find($id)) {
            $id = rand(10000, 99999);
        }
        return (string) $id;
    }

    private function makeUniqueUsername(string $name): array
    {
        $base = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
        if (strlen($base) < 3) $base .= 'user';

        $username = $base;
        $suffix = 1;
        while (GameSession::where('username', $username)->exists()) {
            $suffix++;
            $username = $base . $suffix;
        }
        return [$username, $suffix];
    }
}
