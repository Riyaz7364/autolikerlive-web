<?php

namespace App\SmsSources;

use App\SmsSenderInterface;
use Faker\Provider\UserAgent;

class Housing implements SmsSenderInterface {

    private $api;
    private $userAgnet;

    protected $multi;
    function __construct($multi){
        $this->multi =$multi;
        $this->api = "https://mightyzeus.housing.com/api/gql?apiName=LOGIN_SEND_OTP_API&emittedFrom=client_buy_home&isBot=false&source=web";
        $this->userAgnet ="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36";
    }

    public function sendSMS($to, $code){

        $formData = '
        {
            "query":"\n  mutation($email: String, $phone: String, $otpLength: Int) {\n    sendOtp(phone: $phone, email: $email, otpLength: $otpLength) {\n      success\n      message\n    }\n  }\n",
            "variables":{
                "phone":"'.$to.'"
            }
        }';
        $headers = [
            'Phoenix-Api-Name: LOGIN_SEND_OTP_API',
            'User-Agent: '.$this->userAgnet,
            'Content-Type: application/json',
        ];
       return getConnect($this->api, $formData,  0, 0, $headers);

    }
}
