<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\UniqueLink;
use App\Models\TiktokTimer;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Validator;

class Wordpress extends Controller
{
    public function post(Request $request, $slug){

        $tech_post = Post::where('slug', $slug)->first();
        if(!$tech_post){
            return redirect(url('tech'));
        }
        $showAd = 0;
        $cookie = $request->cookie('session');
        if(isset($_GET['usg'])){
            $session = UniqueLink::where('session', $_GET['usg'])->first();
            if($session){
                //Create a response instance
               // Set a cookie
                Cookie::queue('session', $session->session, 1);

                $request->cookie('session');
                $slug = $tech_post->slug;
                return view("wordpress.redirect", compact('slug'));
            }

        }
        if($cookie){
            $showAd = 1;
            $uniqueLink = UniqueLink::where('session', $cookie)->first();
            $type = $uniqueLink->data['type'];
            $from = "WEB";
            switch ($type) {
                case 'TIKTOK_LIKES':
                    $timer = 60;
                    break;
                case 'FREE_TIKTOK':
                    $timer = 20;
                    break;
                default:
                    $timer = 90;
                    break;
            }

            return view("wordpress.post", compact('tech_post', 'showAd', 'cookie', 'timer'));
        }
        $timer = 1000;
        return view("wordpress.post", compact('tech_post', 'showAd', 'cookie', 'timer'));
    }



    public function createSession(Request $request){
        $validator = Validator::make($request->all(), [
            'link' => 'required|url',
            'type' => 'required',
            'ip' => 'required|ip',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $minerpath = minerpath('refreshUser', $request->token);
        $response = Http::withHeaders($minerpath[1])
        ->get($minerpath[0]);
        if($response->failed()){
            return response()->json([
                'success' => false,
                'message' => 'Login Failed',
            ], 200);
        }

        $user = $response->json();
        $id = $user['user']['id'];
        $link = $request['link'];
        $ip = $request['ip'];
        $type = $request->type;
        $from = isset($request->from) ? "APP" : "WEB";
        $provider = "smm";
        $key = "bf7395babfc40228a2ba48e9c107f949";
        $api = "https://smmsocialmedia.in/api/v2";
        switch ($type) {
            case 'TIKTOK_LIKES':
                $path = "free-tiktok-likes";
                $service_id = 4511;//1083;
                $quantity = 10;
                $provider = "jt";
                $key = "fe4f16ef0e4ba44cf2932c1ba1844a663099afb6";
                $api = "https://smmsocialmedia.in/api/v2";
                break;
            case 'FREE_TIKTOK':
                $service_id = 2491;
                $quantity = 100;
                $path = "free-tiktok-views";
                $provider = "smm";
                $key = "fef081d0d82d678f3d64c3a5cc190179";
                $api = "https://smmsocialmedia.in/api/v2";
                break;
            default:
                $path = "free-instagram-likes";
                $service_id = 32;
                $quantity = 10;
                break;
        }


        $session = uniqid();

        $data = [
            'key' => $key,
            'api' => $api,
            'link' => $link,
            'ip' => $ip,
            'type' => $type,
            'from' => $from,
            'provider' => $provider,
            'service_id' => $service_id,
            'quantity'  =>  $quantity,
        ];


    	$tech_post = Post::inRandomOrder()->first();
    	$slug = $tech_post->slug;
        $uniqueLink = new UniqueLink();
        $uniqueLink->session = $session;
        $uniqueLink->user_id = $id;
        $uniqueLink->order_id = 0;
        $uniqueLink->status = 0;
        $uniqueLink->ip = $ip;
        $uniqueLink->data = $data;
        $uniqueLink->save();
        $url = "https://l.facebook.com/l.php?u=https://autolikerlive.com/tech/$slug?usg=$session";
        return response()->json([
            'success' => true,
            'link' => $url
        ], 200);
    }


    public function submit(Request $request){
        $request->validate([
            'g-recaptcha-response' => 'required',
        ]);

        $g_api = "https://www.google.com/recaptcha/api/siteverify";
        $response = Http::asForm()->post($g_api, [
            'secret'    =>  "6LfGNKYpAAAAAOS3_cKLWGsV5GMKCPkTzwC73Kah",
            'response'  =>  $request['g-recaptcha-response'],
        ]);
        $json = $response->json();

        if($json['success']){
        // if(true){
            $response = $this->storeLink($request);
            $success = $response['success'];
            $order_id = $response['order_id'];
            $session = UniqueLink::where('session', $request['session'])->first();
            $path = $session->session['path'];
            return view('wordpress.success', compact(['success', 'order_id', 'path']));
        }

        echo "Invalid recaptcha";
    }


    private function storeLink(Request $request){

        $session =  $request['session'];

        $ulink = UniqueLink::where('session', $session)->where('status', 0)->first();

        if(!$ulink){
            return [
                'success' => false,
                'message' => "Duplicate Request",
                'order_id'=> null,
            ];
        }
        $request->merge(['link' => $ulink->data['video_id']]);

        $query = array(
            'key'   => $ulink->data['key'],
            'action'    =>  'add',
            'service'   =>  $ulink->data['service_id'],
            'link'      =>  $ulink->data['link'],
            'quantity'  =>  $ulink->data['quantity'],
        );

        $response = $this->curlCall($query, $ulink->data['api']);
        // dd($response);
        if(isset($response->error)){
            return [
                'success' => false,
                'message' => $response->error,
                'order_id'=> null,

            ];
        }
        // Create a new UniqueLink instance
        $uniqueLink = UniqueLink::where('session', $session)->first();
        $uniqueLink->order_id = $response->order;
        $uniqueLink->status = 1;
        // Save the data
        $uniqueLink->save();
        $this->setTimer($request);
        // Optionally, you can return a response indicating success
        return [
            'success' => true,
            'message' => 'Link stored successfully',
            'order_id'=> $response->order,

        ];
    }

    public function getOrders(Request $request){
        $api = "https://miner.autolikerlive.com/api/v1/refreshUser";
        $headers = [
            "Authorization" => $request->header('Authorization'),
            "Accept" => "application/json",
            "Content-Type" => "application/json",
        ];

        $response = Http::withHeaders($headers)->get($api);
        if($response->successful()){
            $user = $response->json();
            $type = $request['type'];
            $user = $user['user'];
            $id = $user['id'];
            $linkData = UniqueLink::where('user_id', $id)
            ->where('status', 1)
            ->whereJsonContains('data->type', $type)
            ->get();
            $links = [];
            foreach($linkData as $link){
                $query = array(
                    'key'   => $link->data['key'],
                    'action'    =>  'status',
                    'order'   =>  $link['order_id'],
                    );
                $response = $this->curlCall($query, $link->data['api']);

                $data['link'] = $link->data['link'];
                $data['status'] = $response->status;
                $data['start_count'] = $response->start_count;
                $links[] = $data;
            }
            return response()->json([
                'success' => true,
                'user_id' => $id,
                'data' => $links
            ]);
        }

    }

    public function setTimer(Request $request){
        $timeRemains = time() + 600;
        $userIp = getUserIP($request);
        // Save or update timer data in the database
        TiktokTimer::updateOrCreate(
            ['id' => $userIp],
            ['timer' => $timeRemains, 'link' => $request['link']]
        );

        return response()->json([
            'success' => true,
            'time' => $timeRemains
        ], 200);
    }

    private function getTimer(Request $request){
        $timeRemains = 0;
        $userIp = getUserIP($request);
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

    public function checkOrder($id){

        $linkData = UniqueLink::where('order_id', $id)->first();
        $query = array(
            'key'   => $linkData->data['key'],
            'action'    =>  'status',
            'order'   =>  $id,
            );
        $response = $this->curlCall($query, $linkData->data['api']);

        if(isset($response->error)){
            return [
                'success' => false,
                'message' => $response->error,
            ];
        }
        return [
            'success' => true,
            'message' => "Status: ".$response->status." Remains: ".$response->remains,
        ];
    }


    private function curlCall($data, $api){

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $api,
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

        // $response = curl_exec($curl);
        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        return $response;
    }
}
