<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
if (!function_exists('getConnect')) {

    function getConnect($url, $data = 0, $useragent = 0, $cookie = 0, $httpheader = array()){

        $ch = curl_init($url);
        //  curl_setopt($ch, CURLOPT_INTERFACE, '104.18.61.166');
        if($useragent) curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        if($httpheader) curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        if($cookie) curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        if ($data):
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        endif;
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch);
        if(!$httpcode) return false; else{
            $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            curl_close($ch);
            return array($header, $body);
        }

    }

}

if(!function_exists('minerpath')) {

    function minerpath($path, $token = false){

        $user = Session::get('my_json_data');
        if(!$token) $token = $user['token']['token'];
        $headers = [
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
        return ["https://miner.autolikerlive.com/api/v1/".$path, $headers];
    }
}

if(!function_exists('miner')) {

    function miner($path, $data = 0){
        $user = Session::get('my_json_data');
        $headers = [
            'Authorization: Bearer '.$user['token']['token'],
            'Accept: application/json',
            'Content-Type: application/json',
        ];
        $url = "https://miner.autolikerlive.com/api/v1/".$path;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        if ($data):
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        endif;
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch);
        if(!$httpcode) return false; else{
            $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            curl_close($ch);
            return array($header, $body);
        }

    }

}

if(!function_exists('loadUser')) {

function loadUser($session){

    $user = $session;

    $api = "https://miner.autolikerlive.com/api/v1/refreshUser";
    $headers = [
        'Authorization: Bearer '.$user['token']['token'],
        'Accept: application/json',
        'Content-Type: application/json',
    ];

    $response = getConnect($api, 0, 0, 0, $headers);
    $json = json_decode($response[1]);

    return $json->user;

}
}

if (!function_exists('getUserData')) {
function getUserData($access_token){
    $api = "https://graph.facebook.com/graphql";

    $response = \Illuminate\Support\Facades\Http::asForm()->post($api, [
        'av'     => 1,
        '__user' => 0,
        'fb_api_caller_class' => 'RelayModern',
        'fb_api_req_friendly_name' => 'CometSettingsDropdownTriggerQuery',
        'server_timestamps' => true,
        'doc_id' => '6287151654667869',
        'access_token'  => $access_token,
    ]);

    return $response->json();
}
}

if (!function_exists('getUserIP')) {
function getUserIP(Illuminate\Http\Request $request) {
    // Check if the request has X-Forwarded-For header
    if ($request->headers->has('X-Forwarded-For')) {
        $ips = explode(',', $request->header('X-Forwarded-For'));
        // The client's IP address will be the first one in the list
        return trim($ips[0]);
    }

    // If X-Forwarded-For header is not present, fallback to the remote address
    return $request->ip();
}
}

if (!function_exists('toolbanner')) {
function toolbanner($color = "text-light"){
    return "
    <div class=\"card-body\">
        <h2 class=\"text-center ".$color."\"><strong>More Tools</strong></h2>
        <div class=\"row justify-content-center\">
            <a href=\"".route('sms-bomber')."\" class=\"col btn btn-warning btn-lg mt-2 m-2\" style=\"font-size: 15px;\">SMS BOMBER</a>
            <a href=\"".route('free-instagram-likes')."\" class=\"col btn btn-primary btn-lg mt-2 m-2\" style=\"font-size: 15px;\">INSTAGRAM AUTO LIKER</a>
            <a href=\"".route('free-tiktok-views')."\" class=\"col btn btn-primary btn-lg mt-2 m-2\" style=\"font-size: 15px;\">FREE TIKTOK VIEWS</a>
            <a href=\"".route('free-tiktok-likes')."\" class=\"col btn btn-secondary btn-lg mt-2 m-2\" style=\"font-size: 15px;\">FREE TIKTOK LIKES</a>
            <a href=\"".route('temp-mail')."\" class=\"col btn btn-info btn-lg mt-2 m-2\" style=\"font-size: 15px;\">TEMP MAIL</a>
            <!--a href=\"https://raje-liker.com/\" class=\"col btn btn-info btn-lg mt-2 m-2\" style=\"font-size: 15px;\">Cheap SMM Panel</a -->
        </div>
    </div>
";
}
}

if (!function_exists('getIcon')) {
function getIcon($name, $class = '') {
    // Handle size classes for better SVG scaling
    $sizeAttr = '';
    if (strpos($class, 'fa-3x') !== false) {
        $sizeAttr = ' width="48" height="48"';
        $class = str_replace('fa-3x', '', $class);
    } elseif (strpos($class, 'fa-2x') !== false) {
        $sizeAttr = ' width="32" height="32"';
        $class = str_replace('fa-2x', '', $class);
    } elseif (strpos($class, 'fs-2') !== false) {
        $sizeAttr = ' width="32" height="32"';
    } elseif (strpos($class, 'fs-4') !== false) {
        $sizeAttr = ' width="24" height="24"';
    } elseif (strpos($class, 'fs-5') !== false) {
        $sizeAttr = ' width="20" height="20"';
    }

    // Clean up class attribute
    $class = trim($class);

    // Define SVG icons map
    $svgIcons = array(
        'android2' => '<svg class="'.$class.'"'.$sizeAttr.' xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-android2" viewBox="0 0 16 16"><path d="m10.213 1.471.691-1.26q.069-.124-.048-.192-.128-.057-.195.058l-.7 1.27A4.8 4.8 0 0 0 8.005.941q-1.032 0-1.956.404l-.7-1.27Q5.281-.037 5.154.02q-.117.069-.049.193l.691 1.259a4.25 4.25 0 0 0-1.673 1.476A3.7 3.7 0 0 0 3.5 5.02h9q0-1.125-.623-2.072a4.27 4.27 0 0 0-1.664-1.476ZM6.22 3.303a.37.37 0 0 1-.267.11.35.35 0 0 1-.263-.11.37.37 0 0 1-.107-.264.37.37 0 0 1 .107-.265.35.35 0 0 1 .263-.11q.155 0 .267.11a.36.36 0 0 1 .112.265.36.36 0 0 1-.112.264m4.101 0a.35.35 0 0 1-.262.11.37.37 0 0 1-.268-.11.36.36 0 0 1-.112-.264q0-.154.112-.265a.37.37 0 0 1 .268-.11q.155 0 .262.11a.37.37 0 0 1 .107.265q0 .153-.107.264M3.5 11.77q0 .441.311.75.311.306.76.307h.758l.01 2.182q0 .414.292.703a.96.96 0 0 0 .7.288.97.97 0 0 0 .71-.288.95.95 0 0 0 .292-.703v-2.182h1.343v2.182q0 .414.292.703a.97.97 0 0 0 .71.288.97.97 0 0 0 .71-.288.95.95 0 0 0 .292-.703v-2.182h.76q.436 0 .749-.308.31-.307.311-.75V5.365h-9zm10.495-6.587a.98.98 0 0 0-.702.278.9.9 0 0 0-.293.685v4.063q0 .406.293.69a.97.97 0 0 0 .702.284q.42 0 .712-.284a.92.92 0 0 0 .293-.69V6.146a.9.9 0 0 0-.293-.685 1 1 0 0 0-.712-.278m-12.702.283a1 1 0 0 1 .712-.283q.41 0 .702.283a.9.9 0 0 1 .293.68v4.063a.93.93 0 0 1-.288.69.97.97 0 0 1-.707.284 1 1 0 0 1-.712-.284.92.92 0 0 1-.293-.69V6.146q0-.396.293-.68"/></svg>',
        'collection' => '<svg class="'.$class.'"'.$sizeAttr.' xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-collection" viewBox="0 0 16 16">
                        <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5z"/>
                    </svg>',
        'shield-check'  =>  '<svg class="'.$class.'"'.$sizeAttr.' xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-shield-check" viewBox="0 0 16 16">
                    <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                    <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                </svg>',
        'bandaid'  =>  '<svg class="'.$class.'"'.$sizeAttr.' xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-bandaid" viewBox="0 0 16 16">
                    <path d="M14.121 1.879a3 3 0 0 0-4.242 0L8.733 3.026l4.261 4.26 1.127-1.165a3 3 0 0 0 0-4.242M12.293 8 8.027 3.734 3.738 8.031 8 12.293zm-5.006 4.994L3.03 8.737 1.879 9.88a3 3 0 0 0 4.241 4.24l.006-.006 1.16-1.121ZM2.679 7.676l6.492-6.504a4 4 0 0 1 5.66 5.653l-1.477 1.529-5.006 5.006-1.523 1.472a4 4 0 0 1-5.653-5.66l.001-.002 1.505-1.492z"/>
                    <path d="M5.56 7.646a.5.5 0 1 1-.706.708.5.5 0 0 1 .707-.708Zm1.415-1.414a.5.5 0 1 1-.707.707.5.5 0 0 1 .707-.707M8.39 4.818a.5.5 0 1 1-.708.707.5.5 0 0 1 .707-.707Zm0 5.657a.5.5 0 1 1-.708.707.5.5 0 0 1 .707-.707ZM9.803 9.06a.5.5 0 1 1-.707.708.5.5 0 0 1 .707-.707Zm1.414-1.414a.5.5 0 1 1-.706.708.5.5 0 0 1 .707-.708ZM6.975 9.06a.5.5 0 1 1-.707.708.5.5 0 0 1 .707-.707ZM8.39 7.646a.5.5 0 1 1-.708.708.5.5 0 0 1 .707-.708Zm1.413-1.414a.5.5 0 1 1-.707.707.5.5 0 0 1 .707-.707"/>
                </svg>',
        'person-workspace'  =>  '<svg class="'.$class.'"'.$sizeAttr.' xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
                    <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                    <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.4 5.4 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z"/>
                </svg>',
        'facebook' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                        </svg>',
        'twitter-x' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                            <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                        </svg>',
        'telegram'  => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telegram" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.287 5.906q-1.168.486-4.666 2.01-.567.225-.595.442c-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294q.39.01.868-.32 3.269-2.206 3.374-2.23c.05-.012.12-.026.166.016s.042.12.037.141c-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8 8 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629q.14.092.27.187c.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.4 1.4 0 0 0-.013-.315.34.34 0 0 0-.114-.217.53.53 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09"/>
                        </svg>',
        'instagram' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                        </svg>',
        'chat-dots' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                        <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                        <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                    </svg>',
        'people'    => '<svg  class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                    </svg>',
        'envelope'  => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                </svg>',
        'tiktok'    => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 16 16">
                        <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/>
                    </svg>',
        'photo' => '<svg  class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                        <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z"/>
                    </svg>',
        'video' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814z"/>
                  </svg>',
        'profile' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-square" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                        </svg>',
        'story' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-heart" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm2 .5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V4a.5.5 0 0 0-.5-.5zm5 4.493c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132"/>
                    </svg>',
        'cast' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cast" viewBox="0 0 16 16">
                    <path d="m7.646 9.354-3.792 3.792a.5.5 0 0 0 .353.854h7.586a.5.5 0 0 0 .354-.854L8.354 9.354a.5.5 0 0 0-.708 0"/>
                    <path d="M11.414 11H14.5a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.5-.5h-13a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .5.5h3.086l-1 1H1.5A1.5 1.5 0 0 1 0 10.5v-7A1.5 1.5 0 0 1 1.5 2h13A1.5 1.5 0 0 1 16 3.5v7a1.5 1.5 0 0 1-1.5 1.5h-2.086z"/>
                </svg>',
        'file-play' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-play" viewBox="0 0 16 16">
                            <path d="M6 10.117V5.883a.5.5 0 0 1 .757-.429l3.528 2.117a.5.5 0 0 1 0 .858l-3.528 2.117a.5.5 0 0 1-.757-.43z"/>
                            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1"/>
                        </svg>',
        'snapchat' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-snapchat" viewBox="0 0 16 16">
                            <path d="M15.943 11.526c-.111-.303-.323-.465-.564-.599a1 1 0 0 0-.123-.064l-.219-.111c-.752-.399-1.339-.902-1.746-1.498a3.4 3.4 0 0 1-.3-.531c-.034-.1-.032-.156-.008-.207a.3.3 0 0 1 .097-.1c.129-.086.262-.173.352-.231.162-.104.289-.187.371-.245.309-.216.525-.446.66-.702a1.4 1.4 0 0 0 .069-1.16c-.205-.538-.713-.872-1.329-.872a1.8 1.8 0 0 0-.487.065c.006-.368-.002-.757-.035-1.139-.116-1.344-.587-2.048-1.077-2.61a4.3 4.3 0 0 0-1.095-.881C9.764.216 8.92 0 7.999 0s-1.76.216-2.505.641c-.412.232-.782.53-1.097.883-.49.562-.96 1.267-1.077 2.61-.033.382-.04.772-.036 1.138a1.8 1.8 0 0 0-.487-.065c-.615 0-1.124.335-1.328.873a1.4 1.4 0 0 0 .067 1.161c.136.256.352.486.66.701.082.058.21.14.371.246l.339.221a.4.4 0 0 1 .109.11c.026.053.027.11-.012.217a3.4 3.4 0 0 1-.295.52c-.398.583-.968 1.077-1.696 1.472-.385.204-.786.34-.955.8-.128.348-.044.743.28 1.075q.18.189.409.31a4.4 4.4 0 0 0 1 .4.7.7 0 0 1 .202.09c.118.104.102.26.259.488q.12.178.296.3c.33.229.701.243 1.095.258.355.014.758.03 1.217.18.19.064.389.186.618.328.55.338 1.305.802 2.566.802 1.262 0 2.02-.466 2.576-.806.227-.14.424-.26.609-.321.46-.152.863-.168 1.218-.181.393-.015.764-.03 1.095-.258a1.14 1.14 0 0 0 .336-.368c.114-.192.11-.327.217-.42a.6.6 0 0 1 .19-.087 4.5 4.5 0 0 0 1.014-.404c.16-.087.306-.2.429-.336l.004-.005c.304-.325.38-.709.256-1.047m-1.121.602c-.684.378-1.139.337-1.493.565-.3.193-.122.61-.34.76-.269.186-1.061-.012-2.085.326-.845.279-1.384 1.082-2.903 1.082s-2.045-.801-2.904-1.084c-1.022-.338-1.816-.14-2.084-.325-.218-.15-.041-.568-.341-.761-.354-.228-.809-.187-1.492-.563-.436-.24-.189-.39-.044-.46 2.478-1.199 2.873-3.05 2.89-3.188.022-.166.045-.297-.138-.466-.177-.164-.962-.65-1.18-.802-.36-.252-.52-.503-.402-.812.082-.214.281-.295.49-.295a1 1 0 0 1 .197.022c.396.086.78.285 1.002.338q.04.01.082.011c.118 0 .16-.06.152-.195-.026-.433-.087-1.277-.019-2.066.094-1.084.444-1.622.859-2.097.2-.229 1.137-1.22 2.93-1.22 1.792 0 2.732.987 2.931 1.215.416.475.766 1.013.859 2.098.068.788.009 1.632-.019 2.065-.01.142.034.195.152.195a.4.4 0 0 0 .082-.01c.222-.054.607-.253 1.002-.338a1 1 0 0 1 .197-.023c.21 0 .409.082.49.295.117.309-.04.56-.401.812-.218.152-1.003.638-1.18.802-.184.169-.16.3-.139.466.018.14.413 1.991 2.89 3.189.147.073.394.222-.041.464"/>
                        </svg>',
        'snapchat' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-snapchat" viewBox="0 0 16 16">
                            <path d="M15.943 11.526c-.111-.303-.323-.465-.564-.599a1 1 0 0 0-.123-.064l-.219-.111c-.752-.399-1.339-.902-1.746-1.498a3.4 3.4 0 0 1-.3-.531c-.034-.1-.032-.156-.008-.207a.3.3 0 0 1 .097-.1c.129-.086.262-.173.352-.231.162-.104.289-.187.371-.245.309-.216.525-.446.66-.702a1.4 1.4 0 0 0 .069-1.16c-.205-.538-.713-.872-1.329-.872a1.8 1.8 0 0 0-.487.065c.006-.368-.002-.757-.035-1.139-.116-1.344-.587-2.048-1.077-2.61a4.3 4.3 0 0 0-1.095-.881C9.764.216 8.92 0 7.999 0s-1.76.216-2.505.641c-.412.232-.782.53-1.097.883-.49.562-.96 1.267-1.077 2.61-.033.382-.04.772-.036 1.138a1.8 1.8 0 0 0-.487-.065c-.615 0-1.124.335-1.328.873a1.4 1.4 0 0 0 .067 1.161c.136.256.352.486.66.701.082.058.21.14.371.246l.339.221a.4.4 0 0 1 .109.11c.026.053.027.11-.012.217a3.4 3.4 0 0 1-.295.52c-.398.583-.968 1.077-1.696 1.472-.385.204-.786.34-.955.8-.128.348-.044.743.28 1.075q.18.189.409.31a4.4 4.4 0 0 0 1 .4.7.7 0 0 1 .202.09c.118.104.102.26.259.488q.12.178.296.3c.33.229.701.243 1.095.258.355.014.758.03 1.217.18.19.064.389.186.618.328.55.338 1.305.802 2.566.802 1.262 0 2.02-.466 2.576-.806.227-.14.424-.26.609-.321.46-.152.863-.168 1.218-.181.393-.015.764-.03 1.095-.258a1.14 1.14 0 0 0 .336-.368c.114-.192.11-.327.217-.42a.6.6 0 0 1 .19-.087 4.5 4.5 0 0 0 1.014-.404c.16-.087.306-.2.429-.336l.004-.005c.304-.325.38-.709.256-1.047m-1.121.602c-.684.378-1.139.337-1.493.565-.3.193-.122.61-.34.76-.269.186-1.061-.012-2.085.326-.845.279-1.384 1.082-2.903 1.082s-2.045-.801-2.904-1.084c-1.022-.338-1.816-.14-2.084-.325-.218-.15-.041-.568-.341-.761-.354-.228-.809-.187-1.492-.563-.436-.24-.189-.39-.044-.46 2.478-1.199 2.873-3.05 2.89-3.188.022-.166.045-.297-.138-.466-.177-.164-.962-.65-1.18-.802-.36-.252-.52-.503-.402-.812.082-.214.281-.295.49-.295a1 1 0 0 1 .197.022c.396.086.78.285 1.002.338q.04.01.082.011c.118 0 .16-.06.152-.195-.026-.433-.087-1.277-.019-2.066.094-1.084.444-1.622.859-2.097.2-.229 1.137-1.22 2.93-1.22 1.792 0 2.732.987 2.931 1.215.416.475.766 1.013.859 2.098.068.788.009 1.632-.019 2.065-.01.142.034.195.152.195a.4.4 0 0 0 .082-.01c.222-.054.607-.253 1.002-.338a1 1 0 0 1 .197-.023c.21 0 .409.082.49.295.117.309-.04.56-.401.812-.218.152-1.003.638-1.18.802-.184.169-.16.3-.139.466.018.14.413 1.991 2.89 3.189.147.073.394.222-.041.464"/>
                        </svg>',
        'bi-chevron-left' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                    </svg>',
        'bi-chevron-right' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/>
                    </svg>',

        'bi-heart-pulse-fill' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-pulse-fill" viewBox="0 0 16 16">
                                <path d="M1.475 9C2.702 10.84 4.779 12.871 8 15c3.221-2.129 5.298-4.16 6.525-6H12a.5.5 0 0 1-.464-.314l-1.457-3.642-1.598 5.593a.5.5 0 0 1-.945.049L5.889 6.568l-1.473 2.21A.5.5 0 0 1 4 9z"/>
                                <path d="M.88 8C-2.427 1.68 4.41-2 7.823 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C11.59-2 18.426 1.68 15.12 8h-2.783l-1.874-4.686a.5.5 0 0 0-.945.049L7.921 8.956 6.464 5.314a.5.5 0 0 0-.88-.091L3.732 8z"/>
                                </svg>',
        'bi-play-fill' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                                    <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/>
                                    </svg>',
        'bi-person-heart' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-heart" viewBox="0 0 16 16">
                            <path d="M9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4m13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276Z"/>
                            </svg>',
        'bi-link-45deg' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-link-45deg" viewBox="0 0 16 16">
                                <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1 1 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4 4 0 0 1-.128-1.287z"/>
                                <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243z"/>
                                </svg>',
        'users' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816a4.1 4.1 0 0 1 1.314-.915c1.012-.44 2.225-.44 3.237 0a4.1 4.1 0 0 1 1.314.915c.32.247.603.522.846.816.713.862 1.09 1.893 1.09 2.904a2.24 2.24 0 0 1-.216 1 .5.5 0 0 1-.784 0A2.24 2.24 0 0 1 11 13c0-1.01-.377-2.042-1.09-2.904a4.1 4.1 0 0 0-.846-.816 3.1 3.1 0 0 0-1.314-.915 3.7 3.7 0 0 0-3.237 0 3.1 3.1 0 0 0-1.314.915c-.32.247-.603.522-.846.816C1.377 10.958 1 11.99 1 13a2.24 2.24 0 0 1-.216 1 .5.5 0 0 1-.784 0A2.24 2.24 0 0 1 0 13c0-1.01.377-2.042 1.09-2.904C1.333 9.602 1.616 9.327 1.936 9.08a4.1 4.1 0 0 1 1.314-.915c1.012-.44 2.225-.44 3.237 0a4.1 4.1 0 0 1 1.314.915c.32.247.603.522.846.816.713.862 1.09 1.893 1.09 2.904z"/>
                    </svg>',
        'heart' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                    </svg>',
        'eye' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                  </svg>',
        'user-plus' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                        </svg>',
        'question-circle' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.496 6.033h.825c.138-.194.337-.38.635-.529.393-.2.903-.334 1.512-.334.62 0 1.129.152 1.522.361s.591.572.591.995c0 .364-.117.648-.361.92-.244.272-.615.529-1.113.771-.498.242-.857.4-1.076.474l-.005.003c-.208.073-.38.15-.456.24-.075.091-.141.227-.141.422v.303h.818v-.264c0-.127.039-.23.117-.31s.19-.145.333-.196l.004-.002c.143-.051.358-.127.644-.242.287-.115.618-.267.939-.479s.591-.472.796-.775.308-.656.308-1.053c0-.673-.312-1.204-.936-1.593S7.474 3.5 6.468 3.5c-.618 0-1.14.128-1.566.384s-.717.6-.717 1.149zm1.825 5.967a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5"/>
                            </svg>',
        'clock' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                   </svg>',
        'user-graduate' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mortarboard-fill" viewBox="0 0 16 16">
                               <path d="M8.211 2.047a.5.5 0 0 0-.422 0L1.746 5.047a.5.5 0 0 0 0 .906l6.043 3a.5.5 0 0 0 .422 0l6.043-3a.5.5 0 0 0 0-.906zm0 8.953a.5.5 0 0 0-.421 0l-5.5 2.75A.5.5 0 0 0 2.5 14v-1.268l5.789-2.894a.5.5 0 0 1 .421 0L14.5 12.732V14a.5.5 0 0 0 .211-.297L8.211 11z"/>
                               <path d="M14.5 10.732v1.268L8.711 14.297a.5.5 0 0 1-.422 0L2.5 12V10.732l5.789 2.895a.5.5 0 0 0 .422 0z"/>
                           </svg>',
        'rocket' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-rocket-takeoff-fill" viewBox="0 0 16 16">
                        <path d="M12.17 9.53c2.307-2.592 3.278-4.684 3.641-6.218.21-.887.214-1.58.16-2.065a3.6 3.6 0 0 0-.108-.563 2 2 0 0 0-.078-.23V.453c-.073-.164-.168-.234-.352-.295a2 2 0 0 0-.16-.045 4 4 0 0 0-.57-.093c-.49-.044-1.19-.03-2.08.188-1.536.374-3.618 1.343-6.161 3.604l-2.4.238h-.006a2.55 2.55 0 0 0-1.524.734L.15 7.17a.512.512 0 0 0 .433.868l1.896-.271c.28-.04.592.013.955.132.232.076.437.16.655.248l.203.083c.196.816.66 1.58 1.275 2.195.613.614 1.376 1.08 2.191 1.277l.082.202c.089.218.173.424.249.657.118.363.172.676.132.956l-.271 1.9a.512.512 0 0 0 .867.433l2.382-2.386c.41-.41.668-.949.732-1.526zm.11-3.699c-.797.8-1.93.961-2.528.362-.598-.6-.436-1.733.361-2.532.798-.799 1.93-.96 2.528-.361s.437 1.732-.36 2.531Z"/>
                        <path d="M5.205 10.787a7.6 7.6 0 0 0 1.804 1.352c-1.118 1.007-4.929 2.028-5.054 1.903-.126-.127.737-4.189 1.839-5.18.346.69.837 1.35 1.411 1.925"/>
                    </svg>',
        'stopwatch' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stopwatch-fill" viewBox="0 0 16 16">
                           <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07A7.001 7.001 0 0 0 8 16a7 7 0 0 0 5.29-11.584l.013-.012.354-.354.353.354a.5.5 0 1 0 .707-.707l-1.414-1.415a.5.5 0 1 0-.707.707l.354.354-.354.354-.012.012A6.97 6.97 0 0 0 9 2.071V1h.5a.5.5 0 0 0 0-1zm2 5.6V9a.5.5 0 0 1-.5.5H4.5a.5.5 0 0 1 0-1h3V5.6a.5.5 0 1 1 1 0"/>
                       </svg>',
        'check' => '<svg class="'.$class.'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                      <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                    </svg>',


        // Add more SVG icons here as needed
    );

    // Return SVG content if the name exists in the map, otherwise return null
    return isset($svgIcons[$name]) ? $svgIcons[$name] : null;
}
}

if (!function_exists('getCurl')) {
function getCurl($link) {
    $curl = curl_init();

    // Define the headers
    $headers = [
        'x-ig-app-id: 936619743392459',
        'User-Agent: Instagram 86.0.0.24.87 Android (15/1.4.3; 420; 411.42857142857144/890.2857142857143; google; sdk_gphone64_x86_64; sdk_gphone64_x86_64; emu64xa; en_US)',
        'Accept-Language: en-US,en;q=0.9,ru;q=0.8',
        'Accept-Encoding: gzip, deflate, br',
        'Accept: */*',
        'Cookie: datr=SeGlZ869KcPHqfl35W57-gxM; ig_did=DE2347EB-3EDD-41E2-AF01-3EF85067ED50; ps_l=1; ps_n=1; mid=Z6XhSQALAAHw6uyAkGAoM8r-BrEz; ig_nrcb=1; csrftoken=wIn1HBYxPwQmluzuNsFVplQbL7Z6gjPx; ds_user_id=11796325697; sessionid=11796325697%3AiaxU8nKEvY7sFQ%3A5%3AAYdpnv3ZckapHCLSmnSXJwSW5nzuhDfxnJZIx40XoA; wd=917x739; rur="CCO\05411796325697\0541772885302:01f760aee62e8a98c00d7e68e96280ee3e364df79bc1514b71c849579014521595d95519"' // Add your cookie value here
    ];

    curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',  // Leave it empty to allow curl to support all available encodings
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => $headers, // Setting the headers
    ));

    $response = curl_exec($curl);

    // Check if there was an error
    if (curl_errno($curl)) {
        echo 'Curl error: ' . curl_error($curl);
        curl_close($curl);
        return null;
    }

    curl_close($curl);

    return json_decode($response, true);
}
}

if (!function_exists('shortcode_to_mediaid')) {
function shortcode_to_mediaid($shortcode){

    $alphabet='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';

    $mediaid = 0;

    foreach(str_split($shortcode) as $letter) {
        $mediaid = ($mediaid*64) + strpos($alphabet, $letter);
    }

    return $mediaid;
}
}

if (!function_exists('generateUUID')) {
function generateUUID() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000, // Version 4
        mt_rand(0, 0x3fff) | 0x8000, // Variant
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}
}

if (!function_exists('quickRandom')) {
function quickRandom($length = 16)
{
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}
}

if (!function_exists('timeAgo')) {
function timeAgo($timestamp) {
    $time = strtotime($timestamp);
    $diff = time() - $time;

    if ($diff < 60) {
        return $diff . " seconds ago";
    } elseif ($diff < 3600) {
        return floor($diff / 60) . " minutes ago";
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . " hours ago";
    } elseif ($diff < 2592000) { // 30 days
        return floor($diff / 86400) . " days ago";
    } elseif ($diff < 31536000) { // 12 months
        return floor($diff / 2592000) . " months ago";
    } else {
        return floor($diff / 31536000) . " years ago";
    }
}
}

if (!function_exists('encrypt_string')) {
function encrypt_string($string)
{
    return Vinkla\Hashids\Facades\Hashids::encode($string);
}
}

if (!function_exists('decode_hash')) {
function decode_hash($hash)
{
    $id = Vinkla\Hashids\Facades\Hashids::decode($hash);

    if (is_array($id) && count($id) > 0) {
        return $id[0];
    }

    return false;
}
}
