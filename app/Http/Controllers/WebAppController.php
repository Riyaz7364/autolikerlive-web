<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Firefox\FirefoxOptions;
use Facebook\WebDriver\Firefox\FirefoxDriver;
use Facebook\WebDriver\Firefox\FirefoxProfile;
use Illuminate\Support\Facades\Storage;
use App\Models\DailyReward;
use App\Models\DailyCheck;
use Carbon\Carbon;
use Exception;
use View;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Session;
class WebAppController extends Controller
{

    public function loadSplash(){
        return view('web-app.splash');
    }

    public function dailyCheckIn(){
        $user = loadUser(Session::get('my_json_data'));
        $rewards = DailyReward::all()->map(function ($reward) {
            // Add CSS logic to each reward item
            return [
                'day' => $reward->day,
                'css' => $reward->css,
                'text' => $reward->text,
                'like' => $reward->FB,
                'follow' => $reward->IG,
                'status' => $reward->reward_status, // 'enabled', 'completed', or 'locked'
            ];
        });

        $uuid = $this->encodeUUID($user->id);
        return view('web-app.daily_check', compact(['rewards', 'uuid']));
    }

    public function claimDailyReward(Request $request){
        $userId = $this->decodeUUID($request['user_id']);
        $msg = "Already Claimed";
        if(DailyCheck::where('user_id', $userId)->exists()){
            $check = DailyCheck::where('user_id', $userId)->latest('created_at')->first();
            if(!$check->created_at->isToday())  {
                DailyCheck::create(['user_id'=>$userId]);
                $msg = $this->forwordClaimDailyReward($check)['message'];
            }
        }else{
            $check = DailyCheck::create(['user_id'=>$userId]);
            $msg = $this->forwordClaimDailyReward($check)['message'];;
        }
        flash($msg);
        return redirect()->back()->with('reload', true);;
    }

    private function forwordClaimDailyReward($check){
            $minerpath = minerpath('claimDailyCheck');
            $response = Http::post($minerpath[0],[
                'user_id' => $check->user_id,
                'like'  => $check->reward->FB,
                'follow'  => $check->reward->IG,
            ]);
            return $response->json();
    }

    public function referral(){
        $user = loadUser(Session::get('my_json_data'));
        $minerpath = minerpath('get_my_referrals');
        $response = Http::withHeaders($minerpath[1])
        ->post($minerpath[0], [

        ]);
        $refs = $response->json();
        // dd($refs);
        return view('web-app.referal_friend', compact('refs'));
    }

    public function referralClaim(){
        $user = loadUser(Session::get('my_json_data'));
        $minerpath = minerpath('claimRefs');
        $response = Http::withHeaders($minerpath[1])
        ->post($minerpath[0], [

        ]);
        $refs = $response->json();
        toastr()->success($refs['message']);
        // dd($refs);
        return redirect()->back();
    }


    public function timeBonusPage(){
        $user = loadUser(Session::get('my_json_data'));
        $minerpath = minerpath('timeBonus');
        $response = Http::withHeaders($minerpath[1])
        ->post($minerpath[0], [

        ]);
        $timebonus = $response->json();
        // dd($timebonus);
        return view('web-app.time_bonus', compact(['user', "timebonus"]));
    }

    public function claimTimeBonus(){
        $user = loadUser(Session::get('my_json_data'));
        $minerpath = minerpath('claimAndResetTimeBonus');
        $response = Http::withHeaders($minerpath[1])
        ->post($minerpath[0], [
            'loginType' =>  'FB',
        ]);
        return $response->json();

    }

    public function selectPost(){
        $user = loadUser(Session::get('my_json_data'));
        $data = ['loginType'=>'FB'];
        $minerpath = minerpath('loadLinks');
        $response = Http::withHeaders($minerpath[1])
        ->post($minerpath[0], [
            'loginType' =>  'FB',
        ]);
        $posts = $response->json();
        View::share('posts', $posts);
        View::share('user', $user);
        return view('web-app.quick_send_list');
    }

    public function sendLikes(Request $request){
        $validator = Validator::make($request->all(), [
            'lid' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Invalid link!"
            ]);
        }

        $user = loadUser(Session::get('my_json_data'));
        $minerpath = minerpath('send_likes_web');
        $response = Http::withHeaders($minerpath[1])
        ->post($minerpath[0], [
            'loginType' =>  'FB',
            'lid' => $request['lid'],
        ]);
       return $response->json();


    }


    public function checkTokenLink(Request $request){
        $validator = Validator::make($request->all(), [
            'link' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error($validator->errors()->first());
            return redirect()->back();
        }

        $url = $request['link'];
        $parsed_url = parse_url($url, PHP_URL_FRAGMENT);
        parse_str($parsed_url, $params);
        $access_token = $params['access_token'] ?? '';
        if (!$access_token) {
            toastr()->error("Access Token not found in url");
            return redirect()->back();
        }

        $response = Http::get("https://graph.facebook.com/v2.6/me?access_token=".$access_token);
        $json = $response->json();
        if(isset($json['error'])){
            toastr()->error("Invalid access token");
            return redirect()->back();
        }
        $image = "https://graph.fb.me/".$json['id']."/picture?type=large&access_token=257931075544071%7Ca19fbd5886d2081430fe02ba9e10ca7d";
        $data = [
            'access_token'  =>  $access_token,
            'name'        =>  $json['name'],
            'c_user'        =>  $json['id'],
            'profile_picture'   =>  $image,
            'from'   =>  "WEB",

        ];

        $minerpath = minerpath('saveAccessTokenWeb');

        $response = Http::withHeaders($minerpath[1])
        ->post($minerpath[0], $data);
        Session::put('fbuser', $data);

        return route('dashboard');
    }


    public function getDevideCode(Request $request){

        $response = Http::post('https://miner.autolikerlive.com/api/v1/getCode',[]);
        $json = $response->json();
        return response()->json([
            'success'   => true,
            'userCode'  => $json['userCode'],
            'code'      => $json['code'],
        ]);
    }

    public function checkLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Missing Paramater'
            ]);
        }

        $code = $request['code'];
        $api = "https://graph.facebook.com/v2.6/device/login_status?code=".$code."&access_token=1174099472704185|0722a7d5b5a4ac06b11450f7114eb2e9";
        $response =  getConnect($api, 1);

        $arr = json_decode($response[1], true);

        if(array_key_exists('access_token', $arr)){
            $access_token = $arr['access_token'];
            $response =  getUserData($access_token);
            $fbuser =  $response['data']['viewer']['actor'];
            $minerpath = minerpath('saveAccessTokenWeb');

            $data = [
                'access_token'      =>  $access_token,
                'name'              =>  $fbuser['name'],
                'c_user'            =>  $fbuser['id'],
                'profile_picture'   =>  $fbuser['profile_picture']['uri'],
            ];

            $response = Http::withHeaders($minerpath[1])
            ->post($minerpath[0], $data);
            $posts = $response->json();


            Session::put('fbuser', $data);

            return response()->json([
                'login' => true
            ]);
        }

        return response()->json([
            'login' => false
        ]);

    }

    public function logout(Request $request){
        Session::forget('fbuser');
        return route('fblogin');
    }

    public function dashboard(Request $request){

        $user = loadUser(Session::get('my_json_data'));
        $data = ['loginType'=>'FB'];
        $minerpath = minerpath('loadLinks');
        $response = Http::withHeaders($minerpath[1])
        ->post($minerpath[0], [
            'loginType' =>  'FB',
        ]);
        $posts = $response->json();
        View::share('posts', $posts);
        View::share('user', $user);
        return view('web-app.dashboard');
    }

    public function checkLink(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'url'   =>  'required',
            'limit'   =>  'required',
            'type'   =>  'required',
            'reactions'   =>  'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   =>  $validator->errors(),
            ]);
        }
        $fbuser = Session::get('fbuser');

        $accessToken = $fbuser['access_token'];

        $data = [
            'link'  =>  $request['url'],
            'limit'  =>  $request['limit'],
            'type'  =>  $request['type'],
            'reactions'  =>  $request['reactions'],
            'profilePic'  =>  $request['profilePic'],
            'access_token'  =>  $accessToken,
            'web'   =>  1,
        ];

        $minerpath = minerpath('checkLink');
        $response = Http::withHeaders($minerpath[1])
        ->post($minerpath[0], $data);

        $posts = $response->json();
        // dd($posts);
        return response()->json([
            'success' =>  $posts['success'],
            'message'   => $posts['success'] ? $posts['data']['name'] : $posts['message'],
        ]);
    }

    public function editlink(Request $request){
        $validator = Validator::make($request->all(),[
            'lid'   =>  'required',
            'link'   =>  'required',
            'limit'   =>  'required',
        ]);
        $input = $request->all();
        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   =>  $validator->errors(),
            ]);
        }
        $minerpath = minerpath('editLink');
        $response = Http::withHeaders($minerpath[1])
        ->post($minerpath[0], $input);
        $posts = $response->json();
        return response()->json([
            'success'=>true,
            'message'=>'Link updated!'
        ]);
    }

    public function deleteLink(Request $request){
        $validator = Validator::make($request->all(),[
            'lid'   =>  'required',
        ]);
        $input = $request->all();
        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   =>  $validator->errors(),
            ]);
        }
        $minerpath = minerpath('deleteLink');
        $response = Http::withHeaders($minerpath[1])
        ->post($minerpath[0], $input);
        $posts = $response->json();
        return response()->json([
            'success'=>true,
            'message'=>'Link deleted!'
        ]);
    }

    public function earnCredit(Request $request){
        $fbuser = Session::get('fbuser');
        $accessToken = $fbuser['access_token'];
        $minerpath = minerpath('sendPerform');
        $response = Http::withHeaders($minerpath[1])
        ->post($minerpath[0], [
            'access_token' => $accessToken,
            'platform'  =>  'WEB',
        ]);
        return $response->body();
        $posts = $response->json();

        if($posts['success'] == true){
            return response()->json([
                'success'=>true,
                'message' => $posts['message'],
                'c' => $posts['credits'],
            ]);
        }
    }




    public function adCredit(Request $request, $token = null){
        $api = "https://miner.autolikerlive.com/api/v1/earnAdToken";
        $response = Http::asForm()->post($api, [
            'adtoken' =>  $token,
        ]);
        if($token == null){
            return redirect('/');
        }
        $data = $response->json();
        $data['id'] = $token;
        return view('earnSuccess', compact('data'));
    }

    // Submit Links

    public function tiktokLikes(Request $request, $token){

    }

    function encodeUUID($user_id) {
        // Generate 16 random bytes
        $data = random_bytes(16);

        // Set version to 0100 (UUID version 4)
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);

        // Set bits 6-7 to 10 (variant DCE 1.1)
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Convert the binary data to a hexadecimal string
        return $this->embedUserIdInUUID(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)), $user_id);
    }

    function decodeUUID($uuidWithUserId){
        $encodedUUID = $this->encodeUUIDToBase64($uuidWithUserId);
        $decodedUUIDWithUserId = $this->decodeBase64ToUUIDWithUserId($encodedUUID);
        return $this->extractUserIdFromUUID($decodedUUIDWithUserId);
    }

    // Function to combine user ID with UUID
    function embedUserIdInUUID($uuid, $userId) {
        // Convert user ID to hex (pad if necessary to ensure it's 8 characters long)
        $userIdHex = str_pad(dechex($userId), 8, '0', STR_PAD_LEFT);

        // Insert the user ID hex at the end of the UUID (or any other portion you prefer)
        $uuidWithUserId = substr($uuid, 0, -8) . $userIdHex;

        return $uuidWithUserId;
    }

    // Function to extract user ID from UUID
    function extractUserIdFromUUID($uuidWithUserId) {
        // Extract the last 8 characters (which hold the user ID in hex)
        $userIdHex = substr($uuidWithUserId, -8);

        // Convert the hex back to a user ID
        return hexdec($userIdHex);
    }

    // Function to encode UUID with user ID to base64
    function encodeUUIDToBase64($uuidWithUserId) {
        // Remove dashes from the UUID
        $uuidWithUserId = str_replace('-', '', $uuidWithUserId);

        // Convert the hex string to binary
        $binaryUUID = hex2bin($uuidWithUserId);

        // Base64 encode the binary data
        return rtrim(strtr(base64_encode($binaryUUID), '+/', '-_'), '=');
    }

    // Function to decode base64 back to UUID with user ID
    function decodeBase64ToUUIDWithUserId($base64) {
        // Base64 decode
        $binaryUUID = base64_decode(strtr($base64, '-_', '+/'));

        // Convert the binary data back to hex
        $hexUUID = bin2hex($binaryUUID);

        // Format the UUID string with dashes (last 8 characters hold the user ID in hex)
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split($hexUUID, 4));
    }


    // Find mY fb ID
    private function getPathFromFBURL($fburl){
             
        $host = parse_url($fburl, PHP_URL_HOST);

        if (!$host || !str_contains($host, 'facebook.com')) {
            throw new Exception('Invalid Facebook URL');
        }

        $path = parse_url($fburl, PHP_URL_PATH);
        $query = parse_url($fburl, PHP_URL_QUERY);

        $pathWithQuery = ltrim($path, '/');

        if ($query) {
            $pathWithQuery .= '?' . $query;
        }     
        
        return $pathWithQuery;
    }



    public function findmyfbid(Request $request){

        $validator = Validator::make($request->all(),[
            'fburl'   =>  'required',
            'g-recaptcha-response'   =>  'required',
            'type' => "nullable|boolean"
        ]);
        $input = $request->all();


        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   =>  $validator->errors(),
            ]);
        }
           
        if(true){

            // Check valid FB link and get path
          
            $pathWithQuery = $this->getPathFromFBURL($input['fburl']);
            $fbServices = new \App\Services\FacebookService();
            $response = $fbServices->getPathData($pathWithQuery);
           
            $source = html_entity_decode($response);
            if(isset($input['type'])) return $source;
            // dd($response->body());
            $id = 0;
            if(preg_match('/userID":"(\d+)/', $source, $match)){
                $id = $match[1];
            }
            elseif (preg_match('/pageID\S:\S(\d+)/', $source, $actor)) {
                $id = $actor[1];
            }
           
            if($id){
                Session::flash('message', $id);
                return redirect()->back();
            }
            Session::flash('fail', "");

            return redirect()->back();
        }else{
            Session::flash('fail', "");

            return redirect()->back();
        }
    }

    public function showSharedCard($hash){
        $filename = $hash . '.png';
        $imagePath = storage_path('app/public/bjp_cards/' . $filename);
        if (!file_exists($imagePath)) {
            abort(404);
        }

        $imageUrl = Storage::disk('public')->url('bjp_cards/' . $filename);

        return view('bjp-nagrikta-card-shared', [
            'imageUrl' => $imageUrl,
            'hash' => $hash,
        ]);
    }

}
