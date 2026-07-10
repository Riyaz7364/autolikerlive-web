<?php

namespace App\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\APIs\UserAgent;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
// Models
use App\Models\Cookie;

class InstaApi
{
    private $graphql;
    private $api;
    private $fbdtsg;

    function __construct(){
        $this->api = "https://i.instagram.com/api/v1/";
        $this->graphql = "https://www.instagram.com/graphql/query";
        $this->fbdtsg = "NAcO0RFiHTsPbVV23LuLS2FvMN6yMMipHmLhqxSlmfwd9OdEhTX8DZw:17843676607167008:1743051909";
    }

    public function getFB($username, $type = 'fbuser'){
            $response = $this->scrapeWeb($username, '', $type);
            \Log::debug($response);
            $json = $response->getData(true);
            if($json['code'] != '200') {

                return [
                    'success' => false,
                    'code' => $json['code'],
                    'username' => isset($json['username']) ? $json['username'] : '',
                    'data' => $json,
                    'error' => $json['error'],
                ];
            } else {
                return $json;
            }

    }

    public function getInsta($username, $type = 'profile'){
        $cookies = $this->getCookie('IG');
        if($cookies){
            $response = $this->scrapeWeb($username, $cookies->cookies, $type);
            $json = $response->getData(true);
            if(isset($json['code'])) {

                if($json['code'] == 900){
                    Cookie::where('id', $cookies->id)->update(['status' => 0]);
                    $this->getInsta($username);
                }

                return [
                    'success' => false,
                    'code' => $json['code'],
                    'media_id' => isset($json['media_id']) ? $json['media_id'] : '',
                    'data' => $json,
                    'error' => $json['error'],
                ];
            } else {
                return $json;
            }
        }else{
            return ['error' => 'Maintenance'];
        }
    }


    function igQuery($docId, $variables, $friendlyName)
    {
        $headers = igHeader();
        $formData = [
            '__user' => '0',
            '__a' => '1',
            'av' => '1',
            'fb_dtsg' => $this->fbdtsg,
            'fb_api_caller_class' => 'RelayModern',
            'fb_api_req_friendly_name' => $friendlyName,
            'variables' => $variables,
            'server_timestamps' => 'true',
            'doc_id' => $docId,
        ];
        // Define API URL based on isWeb flag

        // Send POST request
        $response = Http::withHeaders($headers)
                        ->asForm()
                        ->post($this->graphql, $formData);
        if ($response->failed()) {
            return response()->json(['error' => $response->status()], $response->status());
        }
        return $response->json();
    }

    private function getCookie($loginType){
        return Cookie::where('status', 1)->inRandomOrder()->first();
    }


    public function scrapeWeb($data, $cookies, $type)
    {
        if($type == 'profile'){
            $process = new Process(['node', base_path('node_scripts/scrape_instagram.cjs'), $data, $cookies]);
        }elseif($type == 'post'){
            $process = new Process(['node', base_path('node_scripts/scrape_instagram_post.cjs'), $this->shortcodeToMediaId($data), $cookies]);
        }elseif($type == 'fbuser'){
            $process = new Process(['node', base_path('node_scripts/scrape_facebook.cjs'), $data.'/followers', 'style_renderer,profile_header_renderer', '', 0]);
        }elseif($type == 'fbpost'){
            $process = new Process(['node', base_path('node_scripts/scrape_facebook.cjs'), $data, 'comet_ufi_summary_and_actions_renderer,props', 'story_token', 0]);
        }
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output = trim($process->getOutput());

        // Try to decode the first JSON object from the output
        $data = json_decode($output, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                $output,
            ], 500);
        }

        return response()->json(
           $data,
        );
    }
    private function shortcodeToMediaId($shortcode) {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
        $mediaId = 0;

        for ($i = 0; $i < strlen($shortcode); $i++) {
            $mediaId = ($mediaId * 64) + strpos($alphabet, $shortcode[$i]);
        }

        return (string) $mediaId;
    }

    private function igHeader($cookies, $csrftoken){

        $insta = new UserAgent;
        $ua = $insta->getUserAgent();
        $httpheader = array(
        'Referer'   =>  'https://www.instagram.com/',
        'DNT'   => '1',
        'Cookie'    =>  $cookies,
        'Origin'    =>  'https://www.instagram.com/',
        'X-CSRFToken'   => $csrftoken,
        'X-Requested-With'  =>    'XMLHttpRequest',
        'X-Instagram-AJAX'  =>  '1',
        'Connection'    =>  'close',
        'Cache-Control' =>   'max-age=0',
        'Accept'    =>  '*/*',
        'user-agent'=> $ua,
        'X-Ig-App-Id'   =>  '936619743392459',
        "x-ig-www-claim"    =>  $this->hmaHash(),
        'Accept-Language'   =>  'en-US,en;q=0.9'
      );
        return $httpheader;
     }

     private function hmaHash(){
        // Define the character set
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-';
        $charactersLength = strlen($characters);

        // Generate a random string of length 48
        $randomString = '';
        for ($i = 0; $i < 48; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        // Prepend 'hmac.' to the random string
        $x_ig_www_claim = 'hmac.' . $randomString;

        return $x_ig_www_claim;
    }

}
