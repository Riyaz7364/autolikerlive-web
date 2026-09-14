<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Listing;
use App\Models\AppRelease;
use App\Models\PremiumAccount;
use App\Models\Game;
use App\Http\Controllers\TiktokController; // Adjust the namespace accordingly
use App\Http\Controllers\InstagramController; // Adjust the namespace accordingly
use App\Http\Controllers\TikTokeIframeController; // Adjust the namespace accordingly

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Storage;

use Session;
use View;
class ListingController extends Controller
{
    public function Index(Request $request){

        $listings = Listing::select('id','name','post_id')->get();

        $keyword = str_replace("-", " ", $request['keyword']); // Replaced keyword
        $matchingListing = null;

        foreach ($listings as $listing) {
            if (strtolower($listing->name) === str_replace("-", " ", strtolower($keyword))) {
                $matchingListing = $listing;
                break;
            }
        }
        if($matchingListing && isset($matchingListing['post_id'])){
            $posts = $this->cURL('https://www.autolikerlive.com/blog/api/post/'.$matchingListing['post_id']);
        }else{
            $posts = null;
        }
        $tags = Tag::get();
        $games = Game::where('status', 'published')->orderBy('created_at', 'desc')->get();
        View::share('tags',$tags);
        View::share('posts',$posts);
        View::share('listings',$listings);
        View::share('games',$games);

        if(Listing::where('name', str_replace("-",' ', $request['keyword']))->exists()){
            return view('landing', [
                'keyword' => str_replace("-", " ", $request['keyword']),
                'posts' => $posts,
                'listing' => $matchingListing,
            ]);
        }

        if(Tag::where('name', str_replace("-",' ', $request['keyword']))->exists()){
            return view('index', ['keyword'=> $request['keyword'], "home" => true]);
        }

        if (isset($request['keyword'])) {
            return redirect()->route('index', [], 301);
        }

        $linkedListings = Listing::whereNotNull('post_id')->select('id', 'name', 'post_id')->get();
        $linkedPosts = [];
        foreach ($linkedListings as $ll) {
            $blogPost = $this->cURL('https://www.autolikerlive.com/blog/api/post/' . $ll->post_id);
            if ($blogPost && isset($blogPost->title)) {
                $linkedPosts[] = [
                    'name' => $ll->name,
                    'slug' => str_replace(' ', '-', strtolower($ll->name)),
                ];
            }
        }

        return view('index', compact('linkedPosts'));
    }

    public function fbsub(){
        return view('fbsub');
    }


    public function createQr(Request $request){
        return view('create-qr');

    }

    public function download(Request $request){


        $referer = $request->headers->get('referer');
        $ips = $request->header('X-Forwarded-For');

        if (!empty($ips)) {
            $ip = explode(',', $ips)[0];
        } else {
            $ip = $request->ip();
        }
        $premiumAccount = PremiumAccount::where('ip', $ip)->where('used', 0)->latest()->first();

        $ads = false;
        $code = "";
        if(preg_match('/autolikerlive/', $referer) && $premiumAccount && isset($request->id) && $request->id == $premiumAccount->id){

            $ads = true;
            $code = $premiumAccount->code;
            PremiumAccount::where('ip', $ip)->update(['used' => 1]);
        }

        View::share('ads',$ads);
        View::share('code',$code);
        // Download page: RajeLiker (Play Store) + every app from DB that has an APK on disk
        $instaApp = AppRelease::where('app_name', 'instaliker')->first();
        $apps = AppRelease::where('is_active', true)->orderBy('name')->get()
            ->filter(fn ($a) => $a->apk_path && Storage::disk('local')->exists($a->apk_path))
            ->values();
        return view('download', compact('instaApp', 'apps'));
    }

    function cURL($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        return json_decode($result);
    }

    public function get_token_cookie(){
        return view('extensions.get_token_cookie');
    }

    public function IgCommentLiker(){
        $posts = $this->cURL('https://www.autolikerlive.com/blog/api/post/81');

        // Official app of this page — managed in Admin > App Updates
        $instaApp = AppRelease::where('app_name', 'instaliker')->first();

        return view('instagram-commnet-liker', compact('posts', 'instaApp'));
    }

    public function services(){
        return view('services');
    }
}
