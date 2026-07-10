<?php

namespace App\Http\Controllers\Auth;

use App\Http\APIHelper;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::WebHOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

public function handleGoogleCallback()
{
    $user = Socialite::driver('google')->user();

    $api = APIHelper::path('login');
    $formData = [
        'name' => $user->name,
        'email'=>$user->email,
        'password'=>$user->id,
        'image'=>$user->user['picture'],
        'country'=> "IN",
        'token'=> $user->token,
    ];
    $response = getConnect($api, http_build_query($formData));
    $json =  json_decode($response[1], true);
    // dd($json);
    if($json['success'] == true){
        \Session::put('my_json_data', $json);

       $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            auth()->login($existingUser);
        } else {
            // Create a new user and log them in
            $newUser = new User();
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->token = $json->token->token;

            $newUser->save();

            auth()->login($newUser);
        }
    }


    // Implement your logic here to create or authenticate the user with $user data

    // // Example: Check if the user already exists and log them in


    return redirect()->to('/web-app/'); // Redirect to the desired page after login
}
}
