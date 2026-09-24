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
use App\Models\GoneUrl;
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
            $posts = $this->cleanWpContent($this->cURL('https://www.autolikerlive.com/blog/api/post/'.$matchingListing['post_id']));
        }else{
            $posts = null;
        }
        $tags = Tag::get();
        $games = Game::where('status', 'published')->orderBy('created_at', 'desc')->get();
        View::share('tags',$tags);
        View::share('posts',$posts);
        View::share('listings',$listings);
        View::share('games',$games);

        // Homepage blog feed (latest 3 posts, cached; null on API failure -> section hides).
        $latestPosts = null;
        if (!isset($request['keyword']) || !$request['keyword']) {
            $feed = $this->cURL('https://www.autolikerlive.com/blog/api/latest-posts?limit=3');
            if ($feed && isset($feed->posts) && is_array($feed->posts)) {
                $latestPosts = $feed->posts;
            }
        }
        View::share('latestPosts',$latestPosts);

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
            $slug = strtolower(trim($request['keyword'], '/'));

            // Renamed pages keep their equity (301 to the new URL)
            $redirects = config('seo.redirects', []);
            if (isset($redirects[$slug])) {
                return redirect($redirects[$slug], 301);
            }

            // Intentionally removed pages are gone for good (410)
            if (GoneUrl::isGone($slug)) {
                abort(410);
            }

            return redirect()->route('index', [], 301);
        }

        $linkedListings = Listing::whereNotNull('post_id')->select('id', 'name', 'post_id')->get();
        $linkedPosts = [];
        foreach ($linkedListings as $ll) {
            $blogPost = $this->cURL('https://www.autolikerlive.com/blog/api/post/' . $ll->post_id);
            if ($blogPost && isset($blogPost->title)) {
                $linkedPosts[] = [
                    'name' => trim($ll->name),
                    'slug' => str_replace(' ', '-', strtolower(trim($ll->name))),
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

    /**
     * Sanitize WordPress post content for embedding on Laravel pages:
     * - demote h1 to h2 (page already has its own H1)
     * - upgrade http:// internal links to https:// (cures mixed-content
     *   and "HTTPS links to HTTP" audit flags)
     */
    function cleanWpContent($posts){
        if (! $posts || ! isset($posts->content) || ! is_string($posts->content)) {
            return $posts;
        }
        $html = $posts->content;
        $html = preg_replace('/<(\/?)h1(\s|>)/i', '<$1h2$2', $html);
        $html = str_ireplace(
            ['http://www.autolikerlive.com', 'http://autolikerlive.com'],
            'https://www.autolikerlive.com',
            $html
        );
        $posts->content = $html;
        return $posts;
    }

    /**
     * Fetch the WordPress blog API. Never allowed to break or slow the page:
     * short timeouts, null fallback (prevents 5xx) and 1h cache (fast TTFB).
     */
    function cURL($url, $cacheMinutes = 60){
        // Sentinel-based cache: even failures are cached so a dead blog API
        // can't slow every page load (remember() skips null values).
        $key = 'blog_api_' . md5($url);
        try {
            $cached = \Illuminate\Support\Facades\Cache::get($key);
            if ($cached !== null) {
                return $cached === '__BLOG_NULL__' ? null : $cached;
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_TIMEOUT, 8);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            $result = curl_exec($ch);
            if ($result === false || curl_getinfo($ch, CURLINFO_HTTP_CODE) >= 400) {
                curl_close($ch);
                // Cache failures briefly (10 min) so a blog outage doesn't
                // stall every page, but recovery is picked up quickly.
                \Illuminate\Support\Facades\Cache::put($key, '__BLOG_NULL__', now()->addMinutes(10));
                return null;
            }
            curl_close($ch);
            $decoded = json_decode($result);
            $value = is_object($decoded) ? $decoded : '__BLOG_NULL__';
            \Illuminate\Support\Facades\Cache::put($key, $value, now()->addMinutes($cacheMinutes));
            return $value === '__BLOG_NULL__' ? null : $value;
        } catch (\Throwable $e) {
            \Log::warning('Blog API fetch failed', ['url' => $url, 'error' => $e->getMessage()]);
            return null;
        }
    }

    public function get_token_cookie(){
        return view('extensions.get_token_cookie');
    }

    public function IgCommentLiker(){
        $posts = $this->cleanWpContent($this->cURL('https://www.autolikerlive.com/blog/api/post/81'));

        // Official app of this page — managed in Admin > App Updates
        $instaApp = AppRelease::where('app_name', 'instaliker')->first();

        return view('instagram-commnet-liker', compact('posts', 'instaApp'));
    }

    public function services(){
        return view('services');
    }
}
