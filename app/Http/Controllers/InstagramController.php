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
// Models
use App\Models\Service;
use App\Models\Link;
use App\Models\User;
use App\Models\Activity;

class InstagramController extends Controller
{

    private $api;

    function __construct(InstaApi $instaAPI){
        $this->api = $instaAPI;
    }

    public function autoLikerInstagram(){
        return view('instagram.autoliker');
    }

    public function freeIGViews(Request $request){
        $user = Auth::user();
        $timeLeft = $this->loadTimer($request);
        return view('instagram.free_ig_views', compact(['user', 'timeLeft']));
    }

    public function dashboard(){
        $user = Auth::user();
        return view('instagram.dashboard', compact('user'));
    }

    public function boost(){
        $user = Auth::user();
        $services = Service::where('loginType', $user->loginType)->get();
        return view('instagram.boost', compact(['user', 'services']));
    }

    public function loadEarnLink(){
        $user = Auth::user();
        $uid = $user->uid;
        $link = Link::whereNotExists(function ($q) use ($uid) {
            $q->select(DB::raw(1))
              ->from('activities')
              ->whereColumn('links.link', 'activities.link')  // Use whereColumn instead of whereRaw
              ->where('activities.uid', $uid)
              ->whereColumn('links.service', 'activities.service');
        })
        ->join('users', function($q){
            $q->whereColumn('users.uid', 'links.uid')->selectRaw('users.username');
        })
        ->join('services', function($q){
            $q->whereColumn('services.name' , 'links.service')->selectRaw('services.cost');
        })
        ->where('links.uid', '!=', $uid)
        ->where('links.loginType', $user->earnType)
        ->whereColumn('links.count', '<', 'links.limit') // Use whereColumn for comparing columns
        ->where('links.status', 'running')
        ->select('links.*', 'users.username', 'services.cost')
        ->inRandomOrder()
        ->first();
        if($link){
            $lid = encrypt_string($link->id);
            if($user->earnType == 'IG'){
                $igDomain = 'https://www.instagram.com/';
                switch ($link->service) {
                    case 'likes':
                        $type = 'post';
                        $fopen = $igDomain.'p/'.$link->link;
                        break;
                    case 'reels_likes':
                        $type = 'reel';
                        $fopen = $igDomain.'reel/'.$link->link;
                        break;
                    default:
                        $type = 'profile';
                        $fopen = $igDomain.$link->link;
                        break;
                }
            }else{
                $igDomain = 'https://www.facebook.com/';
                $fopen = $igDomain.$link->link;
                $type = $link->service == 'likes' ? 'post' : 'profile';
            }

            return response()->json([
                'success' => true,
                'message' => 'Loaded',
                'data' => [
                    'tokne' => $lid,
                    'link' => $fopen,
                    'service' => $link->service,
                    'username' => $link->username,
                    'cost' => $link->cost,
                    'type' => $type,
                ]
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No link available',
            ], 503);
        }
    }

    public function earnCheck(Request $request){
        $validator = validator($request->all(), [
            'frsc' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid link'
            ]);
        }

        $user = Auth::user();
        $link = Link::where('links.id', decode_hash($request['frsc']))
        ->join('users', 'users.uid', '=', 'links.uid')
        ->select('links.*', 'users.username')
        ->first();

        if (!$link) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token'
            ]);
        }

        $edge_count_old = $link->edge_count;
        $edge_count = $edge_count_old;

        if($user->earnType == 'IG'){
            if ($link->service == 'followers') {
                $userData = $this->api->getInsta($link->link);
                if(!isset($userData['data']['user'])){
                    if($link->report > 5){
                        $link->status = 'paused';
                    }
                    $link->report += 1;
                    $link->save();
                }
                if ($userData['data']['user']['id'] != $user['uid']) {
                    $edge_count = $userData['data']['user']['edge_followed_by']['count'];
                }
            } else {
                $postData = $this->api->getInsta($link->link, 'post');
                if(!isset($userData['data']['user'])){
                    if($link->report > 5){
                        $link->status = 'paused';
                    }
                    $link->report += 1;
                    $link->save();
                }
                if($postData['data']['user']['id'] != $user['uid']){

                    if($postData['data']['like_and_view_counts_disabled'] == true){
                        $edge_count = $edge_count_old + 1;
                    }else{
                        $edge_count = $postData['data']['like_count'];
                    }
                }
            }
        }else{
            if ($link->service == 'followers') {
                $userData = $this->api->getFB($link->link);

                if(!isset($userData['data']['style_renderer'])){
                    $edge_count = $edge_count_old + 1;
                }else{
                    $id64 = $userData['data']['style_renderer']['collection']['id'];
                    $id = explode(':',base64_decode($id64))[1];
                    if ($id != $user['uid']) {
                        $edge_count = $userData['data']['style_renderer']['collection']['items']['count'];
                        if($edge_count == 0){
                            $edge_count = $edge_count_old + 1;
                        }
                    }
                }
            } else {
                $userData = $this->api->getFB($link->username.'/posts/'.$link->link, 'fbpost');
                $id64 = $userData['data']['comet_ufi_summary_and_actions_renderer-multi'][1]['feedback']['id'];
                $postID = explode(':',base64_decode($id64))[1];
                $data['link'] = $postID;
                $id = $userData['data']['props']['actorID'];
                if($id != $user['uid']){
                   $edge_count = $userData['data']['comet_ufi_summary_and_actions_renderer-multi'][1]['feedback']['reaction_count']['count'];
                }
            }
        }


        // Update the edge_count with the latest count
        $link->edge_count = $edge_count;
        $link->save();

        $service = Service::where('name', $link->service)->first();

        if ($edge_count > $edge_count_old) {
            $cost = $service->cost;
            $link->count += 1;
            $link->save();

            DB::table('activities')->insert([
                'uid' => $user['uid'],
                'oid' => $link->uid,
                'link' => $link->link,
                'credits' => $cost,
                'service' => $link->service,
            ]);

            // Update user credits
            $user->credits += $cost;
            $user->save();

            if($link->count >= $link->limit){
                $link->status = 'completed';
                $link->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'You earned ' . $cost . ' credits',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unable to add credits, make sure you like/follow!',
        ]);
    }


    public function claimBonus(Request $request)
    {
        $user = Auth::user();
        // Check if the user completed 10 promotions
        $completedPromotions = Activity::where('uid', $user->uid)
                                    ->whereDate('created_at', Carbon::today())
                                    ->count();

        if ($completedPromotions < 10) {
            return response()->json([
                'status' => 'info',
                'message' => 'Complete 10 promotions to claim your bonus!'
            ]);
        }

        // Check if the user already claimed today
        if ($user->bonus) {
            return response()->json([
                'status' => 'info',
                'message' => 'You have already claimed your bonus today!'
            ]);
        }
        // Random credit between 10 to 50
        $bonusAmount = rand(10, 20);

        // Save bonus
        $user->bonus = 1;
        $user->credits += $bonusAmount;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => "You have successfully claimed $bonusAmount credits!"
        ]);
    }

    public function settings(){
        $user = Auth::user();
        return view('instagram.settings', compact(['user']));
    }

    public function updateSettings(Request $request){
        $request->validate([
            'earn_source' => 'required',
        ]);

        $user = Auth::user();
        $user->earnType = $request['earn_source'];
        $user->save();
        toastr()->success('Profile updated successfully!');
        return redirect()->back();
    }

    public function freeLikes(Request $request){
        $user = Auth::user();
        $timeLeft = $this->loadTimer($request);
        if($user->loginType == "FB") return redirect()->back();
        return view('instagram.free_likes', compact(['user','timeLeft']));
    }

    public function freeViews(Request $request){
        $user = Auth::user();
        $timeLeft = $this->loadTimer($request);
        return view('instagram.free_views', compact(['user','timeLeft']));
    }

    public function earn(){
        $this->loadEarnLink();
        $user = Auth::user();
        return view('instagram.earn', compact(['user']));
    }

    public function view(){
        $user = Auth::user();
        $links = Link::where('uid', $user->uid)->get();
        return view('instagram.view', compact(['user','links']));
    }

    public function viewUpdate(Request $request){
        $validator = validator($request->all(), [
            'id' => 'required',
            'status' => 'required|in:paused,deleted,running',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Invalid promotion Id'
            ]);
        }
        $user = Auth::user();
        $link = Link::where('id', $request['id'])->where('uid', $user->uid)->first();
        if($link){
            $link['status'] = $request['status'];
            $link->save();
            return response()->json([
                'success'=> true,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'You can update the link for your accounts only!'
            ]);
        }
    }


    public function boostSubmit(Request $request){
        $request->validate([
            'link' => 'required',
            'limit' => 'required',
            'type' => 'required',
        ]);

        $user = Auth::user();
        if(preg_match('/\/(p|reel)\/([A-Za-z0-9_-]+)\/?/',$request['link'], $match) && $user->loginType != 'FB'){
            $post_id = $match[2];
        }elseif($request['type'] == 'followers' || $user->loginType == 'FB'){
            $post_id = $request['link'];
        }else{
            toastr()->error("Invalid link | Post is private");
            return redirect()->back();
        }
        $service = Service::where('name', $request['type'])->first();
        $limit = ceil(abs($request['limit']));
        $cost = $service->cost * $limit;
        if($cost > $user['credits']){
            toastr()->error("Not enough credits");
            return redirect()->back();
        }

        $data = [
            'link' => $post_id,
            'uid' => $user['uid'],
            'limit' => $request['limit'],
            'service'=> $request['type'],
            'loginType'=> $user['loginType'],
        ];



        if($user->loginType == "IG"){
            if($request['type'] == 'followers'){
                $userData = $this->api->getInsta($post_id);
                if($userData['data']['user']['id'] == $user['uid']){
                     $data['edge_count'] = $userData['data']['user']['edge_followed_by']['count'];
                }else{
                     toastr()->error("You can only get follow on ".$user['username']);
                     return redirect()->back();
                }
             }else{
                 $postData = $this->api->getInsta($post_id, 'post');
                 if($postData['data']['user']['id'] == $user['uid']){
                      $data['edge_count'] = $postData['data']['like_count'];
                 }else{
                     toastr()->error("You can only add a link posted by the ".$user['username']);
                     return redirect()->back();
                }
             }
        }else{
            if($request['type'] == 'followers'){
                $userData = $this->api->getFB($post_id);
                $id64 = $userData['data']['style_renderer']['collection']['id'];
                $id = explode(':',base64_decode($id64))[1];
                if($id == $user['uid']){
                     $data['edge_count'] = $userData['data']['style_renderer']['collection']['items']['count'];
                }else{
                     toastr()->error("You can only get follow on ".$user['username']);
                     return redirect()->back();
                }
            }else{
                $uri = parse_url($post_id);
                $userData = $this->api->getFB($uri['path'], 'fbpost');
                $postID = $userData['data']['story_token'];
                $data['link'] = $postID;
                $id = $userData['data']['props']['actorID'];
                if($id == $user['uid']){
                     $data['edge_count'] = $userData['data']['comet_ufi_summary_and_actions_renderer-multi'][1]['feedback']['reaction_count']['count'];
                }else{
                     toastr()->error("You can only add a link posted by the ".$user['username']);
                     return redirect()->back();
                }
            }
        }

        Link::create($data);
        toastr()->success('Promotion started success!');

        $user['credits'] -= $cost;
        $user->save();

        return redirect()->back();
    }


    public function getUserData(Request $request){
        $cookies = $request['cookies'];
        $type = $request['type'];
        $username = $request['username'];
        return $this->api->scrapeWeb($username, $cookies, 'post');
    }


    public function loginWithUsername(Request $request){
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

        if(Auth::attempt(['email' => $username.'@ig.com', 'password' => $username])){
            $user = Auth::user();
            return redirect(route('autoliker.dashboard'));
        }

        $response = $this->api->getInsta($username);

        if(isset($response['error'])){
            toastr()->error($response['error']);
            return redirect()->back();
        }
        $user = $response['data']['user'];

        $img = $user['profile_pic_url'];
        $response = Http::get($img);
        if ($response->successful()) {
            // Save the image as a temporary file
            $imageContent = $response->body();
            $contentType = $response->header('Content-Type');
            $extension = explode('/', $contentType)[1];
            $fileName = 'profile_' . $user['id'] . '.' . $extension;
            Storage::disk('public')->put('profiles/' . $fileName, $imageContent);
            $imagePath = Storage::url('profiles/' . $fileName);
        }else{
            $imagePath = "/storage/profiles/dummy.png";
        }

        $create = [
            'email' => strtolower($user['username']).'@ig.com',
            'password' => strtolower($user['username']),
            'uid' => $user['id'],
            'name' => $user['full_name'],
            'username' => $user['username'],
            'followers' => $user['edge_followed_by']['count'],
            'followings' => $user['edge_follow']['count'],
            'bio' => $user['biography'],
            'credits' => 5,
            'loginType' => 'IG',
            'image' => $imagePath,
        ];

        $user = User::create($create);
        Auth::login($user);

        return redirect(route('autoliker.dashboard'));
    }




    ////  Free Instagram Likes
    public function Index(Request $request){

        $timeRemains = $this->loadTimer($request);
        return view('free-instagram-likes', ['timeLeft' => $timeRemains]);
    }

    public function placeViewOrder(Request $request){

        $validator = Validator::make($request->all(),[
            'post_id'=>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors(["msg" => "Video Link is Required"]);
        }



        $g_api = "https://www.google.com/recaptcha/api/siteverify";
        $response = Http::asForm()->post($g_api, [
            'secret'    =>  "6LeBNncpAAAAAPY1mjoXSbhMlfQ5aubVIkfbqZdj",
            'response'  =>  $request['g-recaptcha-response'],
        ]);
        $json = $response->json();

        if($json['success'] == true){
            $timeRemains = $this->loadTimer($request);
            if($timeRemains > 0){
                return redirect()->back()->withErrors("Something is wrong");
            }
            $video_id = $request['post_id'];

            $query = array(
            'key'   => '1e42426c938c66c9a9823cdaa711b5e8',
            'action'    =>  'add',
            'service'   =>  82,
            'link'      =>  $video_id,
            'quantity'  =>  10
            );


            $response = $this->curlCall($query);

            // dd($response);

            if(isset($response->error)){
                return redirect()->back()->withErrors(['message'=>'Something wrong contact admin!']);
            }


            $this->saveTimer($request);

            return redirect()->back()->with('sucess','Link Added! Likes will send shortly!');
        }

            return redirect()->back()->withErrors("Fail to verify ReCaptcha");


    }




    private function loadTimer(Request $request){
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

    private function saveTimer(Request $request)
    {
        $userIp = getUserIP($request);
        $currentTime = time();
        $timerExpiration = $currentTime + 600;

        // Save or update timer data in the database
        TiktokTimer::updateOrCreate(
            ['id' => $userIp],
            ['timer' => $timerExpiration]
        );

        // You can customize the response as needed
        return response()->json(['message' => 'Timer saved successfully']);
    }


    private function curlCall($data){

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://jtsmmpanel.com/api/v2',
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
