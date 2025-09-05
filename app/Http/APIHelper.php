<?php

namespace App\Http;
class APIHelper{

protected $baseUrl;

    function __construct(){
        $base = $this->baseUrl = "https://miner.autolikerlive.com/api/v1/";

    }

    static function path($path){
        $base = "https://miner.autolikerlive.com/api/v1/";
        return $base . $path;
    }
}