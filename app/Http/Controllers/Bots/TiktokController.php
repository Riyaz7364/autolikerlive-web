<?php

namespace App\Http\Controllers\Bots;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use RuntimeException;
use App\APIs\InstaApi;
use App\Models\UniqueLink;
use App\Models\TiktokTimer;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Wordpress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TiktokController extends Controller
{

    private $api;

    function __construct(InstaApi $instaAPI){
        $this->api = $instaAPI;
    }

    public function Index(Request $request){
        $timeRemains = $this->loadTimer($request);
        return view('free-tiktok-views', ['timeLeft' => $timeRemains, "agent" => new Agent()]);
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

        if(preg_match('/https?:\/\/[^\/]+\.tiktok\.com\/([^\/?]+)/', $request['link'], $match)){
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


            if($request['type'] == "INSTA_LIKES" || $request['type'] == "INSTA_VIEWS"){
                return redirect()->back()->withErrors("Maintenance - Use app to use this service");
                $user = Auth::user();
                $postData = $this->api->getInsta($video_code, 'post');
                if($postData['data']['user']['id'] != $user['uid']){
                    return redirect()->back()->withErrors("You can only add a link posted by the ".$user['username']);
               }
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
                    $query['service'] = 5393;
                    $query['quantity'] = 10;
                    $wait = 10;
                    $status = 0;

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

            if($request['type'] == 'INSTA_LIKES'){
                $user = Auth::user();
                $credits = $user->credits;
                if($credits < 0){
                    return redirect()->back()->withErrors(['message'=> 'Not enough credits']);
                }else{
                    $user->credits = $user->credits - 1;
                    $user->save();
                }
            }

            if(TiktokTimer::where('link', $video_code)
            ->where('updated_at', '>=', Carbon::now()->subMinutes($wait))
            ->exists() || $this->loadTimer($request, $request['telegram_user_id'] ?? null) > 0){
                return redirect()->back()->withErrors("Please wait $wait minutes before add link again.");
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


    // public function createShortLink(Request $request){
    //     $validator = Validator::make($request->all(),[
    //         'link' => 'required',
    //         'type' => 'required',
    //     ]);

    //     if($validator->fails()){
    //         return redirect()->back()->withErrors(["msg" => "Video Link is Required"]);
    //     }

    //     if(preg_match('/https?:\/\/[^\/]+\.tiktok\.com\/([^\/?]+)/', $request['link'], $match)){
    //         $video_code = $match[1];
    //     }elseif(preg_match('/\/(p|reel)\/([A-Za-z0-9_-]+)\/?/',$request['link'], $match)){
    //         $video_code = $match[1];
    //     }else{
    //         return redirect()->back()->withErrors(["msg" => "Invalid Video Link"]);
    //     }

    //     // return redirect()->back()->withErrors(["msg" => "Out of fund - Please come back tommorow"]);

    //     if(TiktokTimer::where('link', $video_code)
    //     ->where('updated_at', '>=', Carbon::now()->subMinutes(10))
    //     ->exists()){
    //         return redirect()->back()->withErrors("Please wait 10 minutes before add same link again.");
    //     }


    //     $session = uniqid();

    //     $provider = "smm";
    //     $key = "bf7395babfc40228a2ba48e9c107f949";
    //     $api = "https://smmsocialmedia.in/api/v2";
    //     switch ($request['type']) {
    //         case 'TIKTOK_LIKES':
    //             $path = "free-tiktok-likes";
    //             $service_id = 0;//4165;//1083;
    //             $quantity = 10;
    //             $provider = "jt";
    //             $key = "fe4f16ef0e4ba44cf2932c1ba1844a663099afb6";
    //             $api = "https://jtsmmpanel.com/api/v2";
    //             break;
    //         case 'FREE_TIKTOK':
    //             $service_id = 7107;
    //             $quantity = 100;
    //             $path = "free-tiktok-views";
    //             $provider = "smm";
    //             $key = "fef081d0d82d678f3d64c3a5cc190179";
    //             $api = "https://smmsocialmedia.in/api/v2";
    //             break;
    //         default:
    //             $path = "free-instagram-likes";
    //             $service_id = 4594;
    //             $quantity = 10;
    //             break;
    //     }


    //     $data = [
    //         'key' => $key,
    //         'api' => $api,
    //         'link' => $request['link'],
    //         'ip' => getUserIP($request),
    //         'type' => $request['type'],
    //         'video_id' => $video_code,
    //         'path' => $path,
    //         'from' => "WEB",
    //         'provider' => $provider,
    //         'service_id' => $service_id,
    //         'quantity'  =>  $quantity,
    //     ];


    // 	$tech_post = Post::inRandomOrder()->first();
    // 	$slug = $tech_post->slug;
    //     $uniqueLink = new UniqueLink();
    //     $uniqueLink->session = $session;
    //     $uniqueLink->user_id = 0;
    //     $uniqueLink->order_id = 0;
    //     $uniqueLink->status = 0;
    //     $uniqueLink->ip = getUserIP($request);
    //     $uniqueLink->data = $data;
    //     $uniqueLink->save();
    //     // $url = "https://href.li/?https://free.webportal.club/session/$session";
    //     $url = "https://href.li/?https://www.autolikerlive.com/tech/$slug?usg=$session";

    //     $getShortJson = Http::get("https://pub.webportal.club/api?api=80473e335f437be37b9dc0ff6a88e216d36e9af2&url=".$url);
    //     $shortLink = $getShortJson->json()['shortenedUrl'];

    //     return redirect($shortLink);
    // }


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
        $timeRemains = 0;
        $userIp = $user_id ?? getUserIP($request);
        $timerData = TiktokTimer::where('id', $userIp)->first();

        if ($timerData) {
            $currentTime = time();


            $timerExpiration = $timerData->timer;

            // Check if 900 seconds have passed
            $timeLeft = ($currentTime - $timerExpiration);

            // dd($timeLeft);
            if ($timeLeft < 0) {
                $timeRemains = abs($timeLeft);
            }
        }

        return $timeRemains;
    }

    private function saveTimer(Request $request, $link, $wait = 10, $user_id = null)
    {
        $userIp = $user_id ?? getUserIP($request);
        $currentTime = time();
        $timerExpiration = $currentTime + ($wait*60);

        // Save or update timer data in the database
        TiktokTimer::updateOrCreate(
            ['id' => $userIp],
            ['timer' => $timerExpiration, 'link' => $link],

        );

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
