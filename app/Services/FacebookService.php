<?php

namespace App\Services;

use Exception;

use Illuminate\Support\Facades\Validator;
use App\Models\GameSession;
use App\Models\FacebookSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
class FacebookService
{

    public $id;
    public $name;
    public $username;

    public function getPathFromFBURL($fburl): string
    {

        $finalUrl = Http::get($fburl)->effectiveUri();

        $host = parse_url($finalUrl, PHP_URL_HOST);

        if (!$host || !str_contains($host, 'facebook.com')) {
            throw new Exception('Invalid Facebook URL');
        }

        $path = parse_url($finalUrl, PHP_URL_PATH);
        $query = parse_url($finalUrl, PHP_URL_QUERY);

        $pathWithQuery = ltrim($path, '/');

        if ($query) {
            $pathWithQuery .= '?' . $query;
        }

        

        return $pathWithQuery;
    }

    public function getPathData($path): string
    {
        $fbSetting = FacebookSetting::first();
        $lsd = $fbSetting->lsd ?? '';
        $fbCookie = $fbSetting->fb_cookie ?? '';

        $data = [
            "route_urls[0]" => $path,
            "__user" => 0,
            "__a" => 1,
            "__comet_req" => 15,
            "lsd" => $lsd
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://www.facebook.com/ajax/bulk-route-definitions/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded',
                'Cookie: ' . $fbCookie,
                "User-Agent: Mozilla/5.0 (platform; rv:geckoversion) Gecko/geckotrail Firefox/firefoxversion"
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function resolveFBId($input)
    {
        if (is_numeric($input)) {
            return $input;
        }

        if (str_starts_with($input, 'http')) {
            $pathWithQuery = $this->getPathFromFBURL($input);
        } else {
            $pathWithQuery = $input;
        }

        $response = $this->getPathData($pathWithQuery);
        $source = html_entity_decode($response);

        if (preg_match('/userID":"(\d+)/', $source, $match)) {
            $this->id = $match[1];
        }

        if (preg_match('/pageID\S:\S(\d+)/', $source, $actor)) {
            $this->id = $match[1];
        }

        if (preg_match('/title":"([^"]+)"/', $source, $nameMatch)) {
            $this->name = $nameMatch[1];
        }
        if (preg_match('/userVanity":"([^"]+)"/', $source, $nameMatch)) {
            $this->username = $nameMatch[1];
        }
    }

    public function getProfilePicUrl($fbId): string
    {
        return 'https://graph.fb.me/' . $fbId . '/picture?type=large&access_token=257931075544071%7Ca19fbd5886d2081430fe02ba9e10ca7d';
    }

    public function getUsernameFromURL($fburl): string
    {
        $path = parse_url($fburl, PHP_URL_PATH);
        return ltrim($path, '/');
    }
}
