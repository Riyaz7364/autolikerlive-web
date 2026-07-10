<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\TiktokTimer;
class TikTokeIframeController extends Controller
{
    public function Index(Request $request){

        $timeRemains = $this->loadTimer($request);
        return view('free-tiktok-views-iframe', ['timeLeft' => $timeRemains]);
    }

    public function placeViewOrder(Request $request){
        return redirect()->back()->with('sucess','Link Added! Views will send shortly!');
        $validator = Validator::make($request->all(),[
            'video_id'=>'required',
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
            $video_id = $request['video_id'];

            $query = array(
            'key'   => 'cNl8jKZOWs9V2gcrUpCQ',
            'action'    =>  'add',
            'service'   =>  0,
            'link'      =>  $video_id,
            'quantity'  =>  100
            );


            $response = $this->curlCall($query);

            if(isset($response->error)){
                return redirect()->back()->withErrors(['message'=>'Something wrong contact admin!']);
            }


            $this->saveTimer($request);

            return redirect()->back()->with('sucess','Link Added! Views will send shortly!');
        }

            return redirect()->back()->withErrors("Fail to verify ReCaptcha");


    }




    private function loadTimer(Request $request){
        $timeRemains = 0;
        $userIp = $request->ip();
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
        $userIp = $request->ip();
        $currentTime = time();
        $timerExpiration = $currentTime + 900;

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
          CURLOPT_URL => 'https://www.cheapsmmlive.com/api/v1',
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
