<?php

namespace App\SmsSources;

use App\SmsSenderInterface;
use Faker\Provider\UserAgent;

class Bdcabs implements SmsSenderInterface {

    private $api;
    private $userAgnet;

    protected $multi;
    function __construct($multi){
        $this->multi =$multi;
        $this->api = "https://bdcabs.com/api/userotp/post";
        $this->userAgnet ="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36";
    }

    public function sendSMS($to, $code){
        $formData = '{"MobileNo":"1712579143","MobileNumber":"'.$code.$to.'","CountryCode":"'.$code.'","Status":"101","OTPCode":""}';
        $headers = [
            'User-Agent: '.$this->userAgnet,
            'Content-Type: application/json',
        ];
       return getConnect($this->api, $formData,  0, 0, $headers);

    }
}
