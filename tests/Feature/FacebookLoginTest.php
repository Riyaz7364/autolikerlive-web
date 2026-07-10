<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FacebookLoginTest extends TestCase
{


    public function test_get_final_link_by_curl(){
        $username = "https://www.facebook.com/share/19BhfSszft/";
        $request = Http::get($username);
        fwrite(STDERR, "Final URL: " . $request->effectiveUri() . "\n");

    }

    public function test_facebook_login_by_share_link(){

        $username = "https://www.facebook.com/share/19BhfSszft/";
        $queryParams = [];

        if (preg_match('/facebook\.com/i', $username)) {
            $normalized = preg_match('/^https?:\/\//', $username) ? $username : 'https://' . $username;
            $parsed = parse_url($normalized);
            fwrite(STDERR, "Parsed URL: " . print_r($parsed, true) . "\n");

            if(preg_match('/\/share\/([^\/]+)/i', $parsed['path'], $matches)){
                $nodePath = "node node_scripts/get_final_url.cjs ". escapeshellarg($username);
                $finalUrl = shell_exec($nodePath);
                $finalParsed = parse_url(trim($finalUrl));
                $username = trim($finalParsed['path'], '/');
            }else{

                if (!empty($parsed['query'])) {
                    parse_str($parsed['query'], $queryParams);
                    if (!empty($queryParams['id'])) {
                        $username = $queryParams['id'];
                    }
                }


                if (empty($username) && !empty($parsed['path'])) {
                    $username = trim($parsed['path'], '/');
                }

                if (!empty($parsed['path']) && empty($queryParams['id'])) {
                    $username = trim($parsed['path'], '/');
                }

                $username = explode('/', $username)[0];
                }

            $username = preg_replace('/[\?&].*/', '', $username);
        }



        fwrite(STDERR, "Extracted Username: " . $username . "\n");
        $this->assertTrue(true);
        if (empty($username)) {
            Session::flash('fail', 'Please enter a valid Facebook username, ID, or profile URL.');
            toastr()->error("Please enter a valid Facebook username, ID, or profile URL.");
            return redirect()->back();
        }

        // if(Auth::attempt(['email' => $username.'@fb.com', 'password' => $username])){
        //     $user = Auth::user();
        //     return redirect(route('autoliker.dashboard'));
        // }

        // $response = $this->api->getFB($username);

        // if(isset($response['error'])){
        //     Session::flash('fail', $response['error']);
        //     toastr()->error($response['error']);
        //     return redirect()->back();
        // }

        // if(!isset($response['data']['style_renderer'])){
        //     Session::flash('fail', 'Account setting not public. Enable profile search visibility in Facebook settings.');
        //     toastr()->error("Account setting not public");
        //     return redirect()->back();
        // }

        // $name = $response['data']['profile_header_renderer']['user']['name'];

        // $followers = $response['data']['style_renderer']['collection']['items']['count'];
        // if($followers == 0){
        //     Session::flash('fail', 'Followers are hidden or not accessible from this profile.');
        //     toastr()->error("Followers too much or hidden");
        //     return redirect()->back();
        // }
        // $id64 = $response['data']['style_renderer']['collection']['id'];
        // $id = explode(':',base64_decode($id64))[1];
        // if(strlen($id) > 25){
        //      $id64 = $response['data']['style_renderer']['collection']['app_section']['id'];
        //      $id = explode(':',base64_decode($id64))[1];
        // }

        // $img = "https://graph.fb.me/".$id."/picture?type=large&access_token=257931075544071%7Ca19fbd5886d2081430fe02ba9e10ca7d";
        // $response = Http::get($img);
        // if ($response->successful()) {
        //     // Save the image as a temporary file
        //     $imageContent = $response->body();
        //     $contentType = $response->header('Content-Type');
        //     $extension = explode('/', $contentType)[1];
        //     $fileName = 'profile_' . $id . '.' . $extension;

        //     $image = Image::read($imageContent)->resize(150, 150)->encodeByExtension($extension, quality: 70);

        //     Storage::disk('public')->put('profiles/' . $fileName, $image);
        //     $imagePath = Storage::url('profiles/' . $fileName);
        // }else{
        //     $imagePath = "/storage/profiles/dummy.png";
        // }

        // $create = [
        //     'email' => strtolower($request['username']).'@fb.com',
        //     'password' => strtolower($request['username']),
        //     'uid' => $id,
        //     'name' => $name,
        //     'username' => $request['username'],
        //     'followers' => $followers,
        //     'followings' => null,
        //     'bio' => null,
        //     'credits' => 10,
        //     'image' => $img,
        //     'loginType' => 'FB',
        // ];

        // $user = User::create($create);
        // Auth::login($user);

        // return redirect(route('autoliker.dashboard'));
    }


    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
