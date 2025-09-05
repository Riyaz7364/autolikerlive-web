<?php

namespace App\CallSources;

use App\SmsSenderInterface;
use Faker\Provider\UserAgent;

class Onecard implements SmsSenderInterface {

    private $api;
    private $userAgnet;

    protected $multi;
    function __construct($multi){
        $this->multi =$multi;
        $this->api = "https://card.fplabs.tech:9000/onecard/bff/openweb/v1/web/otp/voice";
        $this->userAgnet ="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36";
    }

    public function sendSMS($to, $code){
        $formData = [

            "mobile" => $to,
            "deviceType" => "WEB",
        ];
        $headers = [
            'Authorization:ZnBsYWJzOjFGUExhYnMyMzIw',
            'User-Agent: '.$this->userAgnet,
            'Content-Type: application/json',
        ];
        return getConnect($this->api, json_encode($formData),  0, 0, $headers);

    }
}
