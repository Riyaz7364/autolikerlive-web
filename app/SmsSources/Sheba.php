<?php

namespace App\SmsSources;

use App\SmsSenderInterface;
use Faker\Provider\UserAgent;
use Illuminate\Support\Facades\Http;

class Sheba implements SmsSenderInterface {

    private $api;
    private $userAgnet;

    protected $multi;
    function __construct($multi){
        $this->multi =$multi;
        $this->api = "https://accountkit.sheba.xyz/api/shoot-otp";
        $this->userAgnet ="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36";
    }

    public function sendSMS($to, $code){
        $token = $this->getToken();
        if($token == null){
            return null;
        }
        $formData = '
        {
            "mobile": "+'.$code.$to.'",
            "app_id": "8329815A6D1AE6DD",
            "api_token": "'.$token.'"
        }';
        $headers = [
            'User-Agent: '.$this->userAgnet,
            'Content-Type: application/json',
        ];
       return getConnect($this->api, $formData,  0, 0, $headers);

    }

    private function getToken(){
        $api = 'https://accounts.sheba.xyz/api/v1/accountkit/generate/token?app_id=8329815A6D1AE6DD';
        $http = Http::get($api);
        $response = $http->json();
        if($response['code'] == 200){
            return $response['token'];
        }
        return null;
    }

}
