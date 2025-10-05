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







    public function youtubeTEV(){
        return view('youtube_thumbnail_extractor');
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
