<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\TiktokTimer;
use App\APIs\InstaApi;
use App\APIs\UserAgent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;
use Intervention\Image\Laravel\Facades\Image;

// Models
use App\Models\Service;
use App\Models\Link;
use App\Models\User;
use App\Models\Activity;

class FacebookController extends Controller
{
    private $api;

    function __construct(InstaApi $instaAPI){
        $this->api = $instaAPI;
    }

    public function autoliker(){
        return view('instagram.fbautoliker');
    }

    public function login(Request $request){
        $request->validate([
            'username' => 'required',
        ]);

        $g_api = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
        $response = Http::asForm()->post($g_api, [
            'secret' => '0x4AAAAAABUvrqmCFqU8nDsRuy_uFGiovRU',
            'response' => $request['cf-turnstile-response'],
            'remoteip' => $request->header('cf-connecting-ip'),
        ]);
        $json = $response->json();

        if($json['success'] != true){
            toastr()->error("Human verification failed!");
            return redirect()->back();
        }

        $username = strtolower($request['username']);

        if(Auth::attempt(['email' => $username.'@fb.com', 'password' => $username])){
            $user = Auth::user();
            return redirect(route('autoliker.dashboard'));
        }

        $response = $this->api->getFB($username);

        if(isset($response['error'])){
            toastr()->error($response['error']);
            return redirect()->back();
        }

        if(!isset($response['data']['style_renderer'])){
            toastr()->error("Account setting not public");
            return redirect()->back();
        }

        $name = $response['data']['profile_header_renderer']['user']['name'];

        $followers = $response['data']['style_renderer']['collection']['items']['count'];
        if($followers == 0){
            toastr()->error("Followers too much or hidden");
            return redirect()->back();
        }
        $id64 = $response['data']['style_renderer']['collection']['id'];
        $id = explode(':',base64_decode($id64))[1];
        if(strlen($id) > 25){
             $id64 = $response['data']['style_renderer']['collection']['app_section']['id'];
             $id = explode(':',base64_decode($id64))[1];
        }

        $img = "https://graph.fb.me/".$id."/picture?type=large&access_token=257931075544071%7Ca19fbd5886d2081430fe02ba9e10ca7d";
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
        }else{
            $imagePath = "/storage/profiles/dummy.png";
        }

        $create = [
            'email' => strtolower($request['username']).'@fb.com',
            'password' => strtolower($request['username']),
            'uid' => $id,
            'name' => $name,
            'username' => $request['username'],
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
