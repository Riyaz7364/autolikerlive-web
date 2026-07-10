<?php

namespace App\SmsSources;

use App\SmsSenderInterface;
use Faker\Provider\UserAgent;

class Unacademy implements SmsSenderInterface {

    private $api;
    private $userAgnet;

    protected $multi;
    function __construct($multi){
        $this->multi =$multi;
        $this->api = "https://unacademy.com/api/v3/user/user_check/?enable-email=true";
        $this->userAgnet ="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36";
    }

    public function sendSMS($to, $code){
        $formData = '
        {
            "phone":"'.$to.'",
            "country_code":"IN",
            "otp_type":1,
            "email":"",
            "send_otp":true,
            "is_un_teach_user":false
        }';
        $headers = [
            'X-Platform: 0',
            'User-Agent: '.$this->userAgnet,
            'Content-Type: application/json',
        ];
        return getConnect($this->api, $formData,  0, 0, $headers);

    }
}
