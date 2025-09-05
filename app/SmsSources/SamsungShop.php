<?php

namespace App\SmsSources;

use App\SmsSenderInterface;
use Faker\Provider\UserAgent;

class SamsungShop implements SmsSenderInterface {

    private $api;
    private $userAgnet;

    protected $multi;
    function __construct($multi){
        $this->multi =$multi;
        $this->api = "https://www.samsung.com/in/api/v1/sso/otp/init";
        $this->userAgnet ="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36";
    }

    public function sendSMS($to, $code){

        $time = time();
        $headers = [
            'User-Agent: '.$this->userAgnet,
            'Content-Type: application/json',
        ];

        $formData = '
        {
            "user_id":"'.$to.'"
        }';

        return getConnect($this->api, $formData,  0, 0, $headers);

    }
}
