<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PremiumAccount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Session;
use View;
class APIController extends Controller
{

    public function startPremium(Request $request){

    }

    public function activatePremium(Request $request){

    }

    public function checkPremium(Request $request){

    }

    public function messages(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=> $validator->errors()
            ]);
        }
        $email = $request['email'];
        $api = "https://miner.autolikerlive.com/api/v1/allMessages";
        $http = Http::asForm()->post($api,
        [
            'email' => $email,
        ]);
        $data = $http->json();

        return $data;
    }

    public function messageView(Request $request, $id)
    {
        $id = $request->route()->parameters()['id'];
        $api = "https://miner.autolikerlive.com/api/v1/getMessage";
        $http = Http::asForm()->post($api,
        [
            'hash_id' => $id,
        ]);
        $data = $http->json();
        if($data == null){
          return route('temp-mail');
        }
        View::share('email', $data);
        return view('view-temp-mail');

    }


    public function deleteMessage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'meesageid'=>'required',
        ]);

        if($validator->fails()){
           route('temp-mail');
        }
        $id = $request['meesageid'];
        $api = "https://miner.autolikerlive.com/api/v1/deleteMail";
        $data =  json_decode(getConnect($api, 'id='.$id)[1]);

        return route('temp-mail');

    }

    public function deleteMail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'=>'required',
        ]);

        Session::forget('email');

        if($validator->fails()){
            return redirect()->route('temp-mail')->with('error', 'Email is required');
        }

        $email = $request['email'];
        $api = "https://miner.autolikerlive.com/api/v1/deleteAllMail";
        $data =  json_decode(getConnect($api, 'email='.$email)[1]);

        return redirect()->route('temp-mail')->with('success', 'Mail deleted successfully');
    }


    public function updateEmail(Request $request){
        $validator = Validator::make($request->all(), [
           'email' => 'required|email'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Please provide a valid email',
            ], 200);
        }
        $email = $request['email'];
        $api = "https://miner.autolikerlive.com/api/v1/updateEmail";
        $http = Http::asForm()->post($api,
        [
            'email' => $email,
        ]);

        if($http->successful()){
            Session::put('email', $email);
            return response()->json([
                'success' => true,
                'email'=>$email,
            ]);
        }else{
            $data = $http->json();
            return response()->json($data);
        }


    }

    public function youtubeTEV(){
        return view('youtube_thumbnail_extractor');
    }



    public function mailbox(Request $request){
        $api = "https://miner.autolikerlive.com/api/v1/fetchDomains";
        $http = Http::post($api);
        $data = $http->json();
        if(Session::has('email') AND !isset($request['refresh'])){
            $email = Session::get('email');
            return response()->json([
                'email'=>$email,
                'list' => $data['data'],
            ]);
        }

        // Check if the data is valid
        if ($data && isset($data['data']) && isset($data['profiles'])) {
            // Get a random domain
            $randomDomain = $data['data'][array_rand($data['data'])]['name'];

            // Get a random name
            $randomName = $data['profiles'][array_rand($data['profiles'])]['name'];

            // Remove spaces and special characters from the name and make it lowercase
            $randomName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $randomName));

            // Generate the email address
            $email = $randomName.'.'.strtolower(quickRandom(5)) . "@" . $randomDomain;
            Session::put('email', $email);
            return response()->json([
                'email'=>$email,
                'list' => $data['data'],
            ]);
        } else {
            echo "Invalid JSON data.";
        }
    }

    public function checkCookies(Request $request){
        $validator = Validator::make($request->all(), [
            'cookies' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please provide cookies',
            ], 200);
        }

        // Run node script to check cookies
        $cookies = $request->input('cookies'); // Array of cookies

        $command = 'node ' . base_path('node_scripts/check_fb_cookie.cjs') . ' ' . escapeshellarg(json_encode($cookies));

        $output = shell_exec($command);
        return $output = json_decode($output, true);
        if (isset($output['status']) && $output['status'] === true) {
            return response()->json([
                'status' => true,
                'message' => 'Cookies are valid',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Cookies are invalid',
            ], 200);
        }
    }
}
