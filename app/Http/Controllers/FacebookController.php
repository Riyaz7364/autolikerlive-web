<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\APIs\InstaApi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Vinkla\Hashids\Facades\Hashids;
use Intervention\Image\Laravel\Facades\Image;
use Symfony\Component\Process\Process;

// Models
use App\Models\User;

class FacebookController extends Controller
{
    private $api;

    function __construct(InstaApi $instaAPI)
    {
        $this->api = $instaAPI;
    }

    public function autoliker()
    {
        return view('instagram.fbautoliker');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
        ]);

        $g_api = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
        $response = Http::asForm()->post($g_api, [
            'secret' => '0x4AAAAAABUvrqmCFqU8nDsRuy_uFGiovRU',
            'response' => $request['cf-turnstile-response'],
            'remoteip' => $request->header('cf-connecting-ip'),
        ]);
        $json = $response->json();

        if ($json['success'] != true) {
            Session::flash('fail', 'Human verification failed.');
            toastr()->error('Human verification failed!');
            return redirect()->back();
        }

        $queryParams = [];
        $username = $request['username'];

        if (preg_match('/facebook\.com/i', $username)) {
            $normalized = preg_match('/^https?:\/\//', $username) ? $username : 'https://' . $username;
            $parsed = parse_url($normalized);
            \Log::debug("Url Parse Data:" . print_r($parsed, true));

            if (preg_match('/\/share\/([^\/]+)/i', $parsed['path'], $matches)) {
                // \Log::debug("Shared Link Found");
                // $nodePath = 'node node_scripts/get_final_url.cjs ' . escapeshellarg($username);
                // \Log::debug("Node Path for execution: " . $nodePath);
                // $finalUrl = shell_exec($nodePath);
                // \Log::debug("Final URL: " . $finalUrl);
                // $finalParsed = parse_url(trim($finalUrl));
                // \Log::debug("Final URL Parse Data:" . print_r($finalParsed, true));
                $request = Http::get($username);
                $finalUrl = $request->effectiveUri();
                \Log::debug("Final URL after HTTP request: " . $finalUrl);
                $finalParsed = parse_url(trim($finalUrl));
                \Log::debug("Final URL Parse Data:" . print_r($finalParsed, true));
                $username = trim($finalParsed['path'], '/');
            } else {
                if (!empty($parsed['query'])) {
                    parse_str($parsed['query'], $queryParams);
                    if (!empty($queryParams['id'])) {
                        $username = $queryParams['id'];
                    }
                }

                if (empty($username) && !empty($parsed['path'])) {
                    $username = trim($parsed['path'], '/');
                }

                if (!empty($parsed['path']) && empty($queryParams['id'])) {
                    $username = trim($parsed['path'], '/');
                }

                $username = explode('/', $username)[0];
            }

            $username = preg_replace('/[\?&].*/', '', $username);
        }

        if (empty($username)) {
            Session::flash('fail', 'Please enter a valid Facebook username, ID, or profile URL.');
            toastr()->error('Please enter a valid Facebook username, ID, or profile URL.');
            return redirect()->back();
        }

        if (Auth::attempt(['email' => $username . '@fb.com', 'password' => $username])) {
            $user = Auth::user();
            return redirect(route('autoliker.dashboard'));
        }

        $response = $this->api->getFB($username);

        if (isset($response['error'])) {
            Session::flash('fail', $response['error']);
            toastr()->error($response['error']);
            return redirect()->back();
        }

        if (!isset($response['data']['style_renderer'])) {
            Session::flash('fail', 'Account setting not public. Enable profile search visibility in Facebook settings.');
            toastr()->error('Account setting not public');
            return redirect()->back();
        }

        $name = $response['data']['profile_header_renderer']['user']['name'];

        $followers = $response['data']['style_renderer']['collection']['items']['count'];
        if ($followers == 0) {
            Session::flash('fail', 'Followers are hidden or not accessible from this profile.');
            toastr()->error('Followers too much or hidden');
            return redirect()->back();
        }
        $id64 = $response['data']['style_renderer']['collection']['id'];
        $id = explode(':', base64_decode($id64))[1];
        if (strlen($id) > 25) {
            $id64 = $response['data']['style_renderer']['collection']['app_section']['id'];
            $id = explode(':', base64_decode($id64))[1];
        }

        $img = 'https://graph.fb.me/' . $id . '/picture?type=large&access_token=257931075544071%7Ca19fbd5886d2081430fe02ba9e10ca7d';
        $response = Http::get($img);
        if ($response->successful()) {
            // Save the image as a temporary file
            $imageContent = $response->body();
            $contentType = $response->header('Content-Type');
            $extension = explode('/', $contentType)[1];
            $fileName = 'profile_' . $id . '.' . $extension;

            $image = Image::read($imageContent)->resize(150, 150)->encodeByExtension($extension, quality: 70);

            Storage::disk('public')->put('profiles/' . $fileName, $image);
            $imagePath = Storage::url('profiles/' . $fileName);
        } else {
            $imagePath = '/storage/profiles/dummy.png';
        }

        $create = [
            'email' => strtolower($request['username']) . '@fb.com',
            'password' => strtolower($request['username']),
            'uid' => $id,
            'name' => $name,
            'username' => $username,
            'followers' => $followers,
            'followings' => null,
            'bio' => null,
            'credits' => 10,
            'image' => $img,
            'loginType' => 'FB',
        ];

        $user = User::create($create);
        Auth::login($user);

        return redirect(route('autoliker.dashboard'));
    }
}
