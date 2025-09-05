<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Listing;
use View;
class ListingController extends Controller
{
    public function Index(Request $request){
        $routes = Route::getRoutes();
        $tags = Tag::select('name')->get();
        $listings = Listing::select('name')->get();

        $posts = $this->cURL('https://www.autolikerlive.com/blog/wp-json/wp/v2/posts?per_page=3');
       
        View::share('tags',$tags);
        View::share('posts',$posts);
        View::share('listings',$listings);
        foreach ($routes as $value) {
            $uri = $value->uri();
            if($request['keyword'] == $uri){
                return view("$uri");
            }
        }
        return view('index', ['keyword'=> $request['keyword']]);
    }

    function cURL($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        return json_decode($result);
    }
}
