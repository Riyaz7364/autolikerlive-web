<?php

namespace App\SmsSources;

use App\SmsSenderInterface;
use Faker\Provider\UserAgent;

class Wakefit implements SmsSenderInterface {

    private $api;
    private $userAgnet;

    protected $multi;
    function __construct($multi){
        $this->multi =$multi;
        $this->api = "https://api.wakefit.co/api/consumer-sms-otp/";
        $this->userAgnet ="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36";
    }

    public function sendSMS($to, $code){
        $formData = '
        {
            "mobile":"'.$to.'",
            "whatsapp_opt_in":1
        }';
        $headers = [
            'Api-Secret-Key: ycq55IbIjkLb',
            'Api-Token: c84d563b77441d784dce71323f69eb42',
            'User-Agent: '.$this->userAgnet,
            'Content-Type: application/json',
        ];
       return getConnect($this->api, $formData,  0, 0, $headers);

    }
}
