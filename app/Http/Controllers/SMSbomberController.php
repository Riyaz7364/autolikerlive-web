<?php

namespace App\Http\Controllers;

use Session;
use App\SmsManager;
use App\CallManager;
use App\Models\Bomber;
use App\Models\BomberStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SMSbomberController extends Controller
{

    protected $smsManager;
    protected $callManager;

    function __construct(SmsManager $smsManager, CallManager $callManager){

        $this->smsManager = $smsManager;
        $this->callManager = $callManager;
    }

    public function index(){
        $status = BomberStatus::all();
        return view('sms-bomber',compact('status'));
    }
    public function callbomber(){
        $status = BomberStatus::all();
        return view('call-bomber',compact('status'));
    }



    public function sendSMS(Request $request){
        $validator = Validator::make($request->all(),[
            'number'=>'required',
            'code'=>'required',
        ]);


        if($validator->fails()){
            return response()->json(['success' => false, 'message'=>'All field required!']);

        }
        $to = $request['number'];
        $code = $request['code'];

        if(Bomber::where('number', $to)->first()){
            return response()->json(['success' => false, 'message'=>'This Number is Secured!']);
        }

        // Process and validate the form data here

        // Verify reCAPTCHA v3
        $recaptchaSecretKey = '6Le9PSErAAAAAM6PvOwbYlLHDeXShsAqDn1X2pMp'; // Your reCAPTCHA secret key
        $recaptchaResponse = $request->input('recaptcha-token');
        $recaptcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecretKey&response=$recaptchaResponse");
        $recaptcha = json_decode($recaptcha);

        if (true) {
                if($request['call']){
                    $this->callManager->sendCALLthroueAllSources($to, $code);
                }else{
                     $this->smsManager->sendSMSthroueAllSources($to, $code);
                }
        } else {
            // reCAPTCHA verification failed
            return response()->json(['error' => 'reCAPTCHA verification failed'], 400);
        }
    }


    public function secureNumber(Request $request){
        $validator = Validator::make($request->all(),[
            'number'=>'required',
        ]);


        if($validator->fails()){
            Session::flash('message', 'Mobile Number is required!');
            return redirect()->back();
        }

        $number = $request['number'];
        $input['number'] = $number;

       try{
        Bomber::create($input);
        toastr()->success('Number Secured Successfully');
        return redirect()->back();
       }catch(\Exception $e){
           toastr()->success('Update Failed');
           return redirect()->back();
       }

    }

}
