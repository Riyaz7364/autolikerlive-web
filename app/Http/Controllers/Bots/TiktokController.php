<?php

namespace App\Http\Controllers\Bots;

use Carbon\Carbon;
use RuntimeException;
use App\Models\TiktokTimer;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Wordpress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TiktokController extends Controller
{

    public function Index(Request $request){
        $timeRemains = $this->loadTimer($request);
        // Latest submitted video in the queue (for instant back-to-back repeat warning).
        $lastTiktokLink = null;
        try {
            $lastTiktokLink = TiktokTimer::lastLink();
        } catch (\Throwable $e) {
            $lastTiktokLink = null;
        }
        return view('free-tiktok-views', ['timeLeft' => $timeRemains, "agent" => new Agent(), 'lastTiktokLink' => $lastTiktokLink]);
    }

    public function selectService(Request $request){
        return view('bots.free-services.select-service');
    }

    public function freeTikTokLikes(Request $request, $user_id){
        $timeLeft = $this->loadTimer($request, $user_id);
        return view('bots.free-services.free-tiktok-likes', compact('timeLeft'));
    }

    public function freeTikTokViews(Request $request, $user_id){
        $timeLeft = $this->loadTimer($request, $user_id);
        return view('bots.free-services.free-tiktok-views', compact('timeLeft'));
    }

    public function freeInstagramLikes(Request $request, $user_id){
        $timeLeft = $this->loadTimer($request, $user_id);
        return view('bots.free-services.free-instagram-likes', compact('timeLeft'));
    }

    public function placeViewOrder(Request $request){


        // return redirect()->back()->withErrors("Maintenance - Use app to use this service");

        $validator = Validator::make($request->all(),[
            'link'=>'required',
            'telegram_user_id' => 'nullable',
        ]);


        if($validator->fails()){
            return redirect()->back()->withErrors(["msg" => "Video Link is Required"]);
        }

        if($request['type'] == "INSTA_LIKES" || $request['type'] == "INSTA_VIEWS"){
            $video_code = $this->extractInstagramCode($request['link']);
            if($video_code === ''){
                return redirect()->back()->withErrors(["msg" => "Invalid Instagram Link"]);
            }
        }elseif(preg_match('/https?:\/\/[^\/]+\.tiktok\.com\/([^\/?]+)/', $request['link'], $match)){
            $video_code = $match[1];
        }elseif(preg_match('/\/(p|reel)\/([A-Za-z0-9_-]+)\/?/',$request['link'], $match)){
            $video_code = $match[2];
        }else{
            return redirect()->back()->withErrors(["msg" => "Invalid Video Link"]);
        }

        $g_api = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
        $response = Http::asForm()->post($g_api, [
            'secret' => '0x4AAAAAABUvrqmCFqU8nDsRuy_uFGiovRU',
            'response' => $request['cf-turnstile-response'],
            'remoteip' => $request->header('cf-connecting-ip'),
        ]);
        $json = $response->json();

        if($json['success'] == true){
              $ip = $request->header('CF-Connecting-IP')
       ?: explode(',', $request->header('X-Forwarded-For'))[0]  // first in list
       ?: $request->ip();

            if ($this->isBlockedIp($ip)) {
                abort(403, 'VPN / Proxy access is not allowed.');
            }


            $timeRemains = $this->loadTimer($request, $request['telegram_user_id'] ?? null);
            if($timeRemains){
                return redirect()->back()->withErrors("PLease wait ".$timeRemains.' seconds before new request');
            }

            $video_id = $request['link'];
            $query = array(
                'key'   => 'fef081d0d82d678f3d64c3a5cc190179',
                'action'    =>  'add',
                'service'   =>  7107,
                'link'      =>  $video_id,
                'quantity'  =>  100
            );


            if($request['type'] == "INSTA_VIEWS"){
                return redirect()->back()->withErrors("Maintenance - Use app to use this service");
            }

            switch ($request['type']) {
                case 'TIKTOK_LIKES':
                    $query['service'] = 5838;
                    $query['quantity'] = 10;
                    $wait = 15;
                    $status = 1;

                    break;
                case 'FREE_TIKTOK':
                    $query['service'] = 7107;
                    $query['quantity'] = 100;
                    $wait = 10;
                    $status = 1;
                    break;
                case 'FB_VIEWS':
                    $query['service'] = 4988;
                    $query['quantity'] = 100;
                    $wait = 10;
                    $status = 0;

                    break;
                case 'INSTA_LIKES':
                    $query['service'] = 5269;
                    $query['quantity'] = 10;
                    $wait = 10;
                    $status = 1;

                    break;
                case 'INSTA_VIEWS':
                    $query['service'] = 4761;
                    $query['quantity'] = 100;
                    $wait = 10;
                    $status = 0;

                    break;
                default:
                    $wait = 0;
                    $status = 0;

                    break;
            }


            if(!$status){
                return redirect()->back()->withErrors(['message'=> 'This service is unavailable! Please check later']);
            }


            if(!$wait){
                return redirect()->back()->withErrors(['message'=> 'Unknwon error']);
            }

            if(TiktokTimer::where('link', $video_code)
            ->where('updated_at', '>=', Carbon::now()->subMinutes($wait))
            ->exists() || $this->loadTimer($request, $request['telegram_user_id'] ?? null) > 0){
                return redirect()->back()->withErrors("Please wait $wait minutes before add link again.");
            }

            // Fair-queue rule: the same link can't go twice in a row.
            // It can be submitted again only after someone else adds their link.
            $normalizedVideo = $this->normalizeQueueLink($video_code);
            if ($normalizedVideo !== '') {
                try {
                    $lastQueued = TiktokTimer::lastLink();
                    if ($lastQueued !== null && $this->normalizeQueueLink($lastQueued) === $normalizedVideo) {
                        $repeatKey = $request['type'] == 'INSTA_LIKES' ? 'instagram_repeat_blocked' : 'tiktok_repeat_blocked';
                        return redirect()->back()->withInput()->with($repeatKey, true);
                    }
                } catch (\Throwable $e) {
                    \Log::warning('Repeat-check skipped: ' . $e->getMessage());
                }
            }

            $response = $this->curlCall($query);

            // dd($response);

            if(isset($response->error)){
                return redirect()->back()->withErrors(['message'=> $response->error]);
            }



            $this->saveTimer($request, $video_code, $wait, $request['telegram_user_id'] ?? null);

            return redirect()->back()->with('sucess','Link Added! will be send shortly!');
        }

        return redirect()->back()->withErrors("Fail to verify ReCaptcha");

    }

    function isBlockedIp(string $ip): bool
    {
        $ipHubKey = config('services.iphub.key');
        if (!$ipHubKey) {
            throw new RuntimeException('IPHUB_KEY missing from environment');
        }

        $info = Http::timeout(3)
            ->withHeaders(['X-Key' => $ipHubKey])
            ->get("http://v2.api.iphub.info/ip/{$ip}")
            ->json();

        // 0 = residential & clean
        // 1 = non-residential (proxy/VPN/datacenter) -- block
        // 2 = residential but suspicious -- block
        return ($info['block'] ?? 0) >= 1;
    }


    public function likesView(Request $request) {
        $timeRemains = $this->loadTimer($request);
        return view('free-tiktok-likes', ['timeLeft' => $timeRemains, "agent" => new Agent()]);
    }


    public function checkOrder(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors(["orderMsg" => "Order ID is Required"]);
        }

        $response = (new Wordpress)->checkOrder($request['id']);

        if($response['success']){
            return redirect()->back()->with('orderStatus', $response['message']);
        }else{
            return redirect()->back()->withErrors(["orderMsg" => $response['message']]);
        }
    }



    private function loadTimer(Request $request, $user_id = null){
        return TiktokTimer::secondsLeft((string) ($user_id ?? getUserIP($request)));
    }

    /**
     * Pull the comparable identifier out of an Instagram URL:
     * instagram.com/p/<code>, /reel/<code>, /tv/<code> or a bare shortcode.
     */
    private function extractInstagramCode($link): string
    {
        $link = trim((string) $link);
        if ($link === '') {
            return '';
        }

        if (preg_match('#instagram\.com/(?:[^/?]+/)?(?:p|reel|reels|tv|share)/([A-Za-z0-9_-]+)#i', $link, $m)) {
            return $m[1];
        }

        if (preg_match('#^(?:https?://)?(?:www\.)?instagram\.com/?([A-Za-z0-9_-]{5,})/?#i', $link, $m)) {
            return $m[1];
        }

        // Bare shortcode pasted on its own.
        if (preg_match('#^[A-Za-z0-9_-]{5,}$#', $link)) {
            return $link;
        }

        return '';
    }

    /**
     * Normalize a submitted link identifier for fair-queue comparison:
     * trim, drop fragment, lowercase scheme+host when URL-like,
     * remove trailing slash. Query string is kept as-is.
     */
    private function normalizeQueueLink(?string $url): string
    {
        $url = trim((string) $url);
        if ($url === '') {
            return '';
        }
        $hashPos = strpos($url, '#');
        if ($hashPos !== false) {
            $url = substr($url, 0, $hashPos);
        }
        $parts = parse_url($url);
        if ($parts === false || !isset($parts['host'])) {
            return strtolower(rtrim($url, '/'));
        }
        $scheme = isset($parts['scheme']) ? strtolower($parts['scheme']) . '://' : '';
        $host = strtolower($parts['host']);
        $path = $parts['path'] ?? '';
        $query = (isset($parts['query']) && $parts['query'] !== '') ? '?' . $parts['query'] : '';
        return rtrim($scheme . $host . $path . $query, '/');
    }

    private function saveTimer(Request $request, $link, $wait = 10, $user_id = null)
    {
        TiktokTimer::record((string) ($user_id ?? getUserIP($request)), (string) $link, (int) $wait);

        // You can customize the response as needed
        return response()->json(['message' => 'Timer saved successfully']);
    }


    private function curlCall($data){

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://smmsocialmedia.in/api/v2',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => http_build_query($data),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));

        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        return $response;
    }

}
