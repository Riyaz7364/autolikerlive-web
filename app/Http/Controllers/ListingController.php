<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Listing;
use App\Models\PremiumAccount;
use App\Models\Game;
use App\Http\Controllers\TiktokController; // Adjust the namespace accordingly
use App\Http\Controllers\InstagramController; // Adjust the namespace accordingly
use App\Http\Controllers\TikTokeIframeController; // Adjust the namespace accordingly

use Illuminate\Support\Facades\App;

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

        return view('index');
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
        return view('download');
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

        return view('instagram-commnet-liker', compact('posts'));
    }

    public function services(){
        return view('services');
    }
}
