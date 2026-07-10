<?php

namespace App\SmsSources;

use App\SmsSenderInterface;
use Faker\Provider\UserAgent;

class A23 implements SmsSenderInterface {

    private $api;
    private $userAgnet;

    protected $multi;
    function __construct($multi){
        $this->multi =$multi;
        $this->api = "https://pfapi.a23games.in/a23user/signup_by_mobile_otp/v2";
        $this->userAgnet ="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36";
    }

    public function sendSMS($to, $code){

        $countryCode = str_replace('+','',$code);
        $formData = '
        {
            "channel":"web",
            "device_id":"'.generateUUID().'",
            "model":"Google,Android SDK built for x86,10",
            "version":"1.0.5",
            "mobile":"+'.$countryCode.''.$to.'",
            "otp":"",
            "type":"signup",
            "referBy":""
        }';

        $headers = [
            'User-Agent: '.$this->userAgnet,
            'Content-Type: application/json',
        ];
        return getConnect($this->api, $formData,  0, 0, $headers);

    }
}
