<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
class DownloaderController extends Controller
{
    public function getAvatar(){
        return view("instagram.avatar");
    }
    public function getAvatarAjax(Request $request){
        $validator = validator()->make($request->all(), [
            'url' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ],400);
        }
        if(isset($request['app'])){
            $json = ["success" => true];
        }else{
            $g_api = "https://www.google.com/recaptcha/api/siteverify";
            $response = Http::asForm()->post($g_api, [
                'secret'    =>  "6LdsafIpAAAAAJcPACyqXoMlbLK6ZO4rOYfQAxsD",
                'response'  =>  $request['g-recaptcha-response'],
            ]);
            $json = $response->json();
        }


        // if($json['success'] == true){
        if(true){
            $link = $request['username'] != null ? "https://www.instagram.com/".$request['username']."/" : $request['url'];

            $user = $this->scrapeUser(trim($this->extractUsername($link)));

            if(!$user['success']){
                return response()->json([
                    'success' => false,
                    'message' => "Invalid username"
                ],400);
            }

            $user = $user['user'];
            $img = $user['profile_pic_url'];
            $response = Http::get($img);
            if ($response->successful()) {
                // Save the image as a temporary file
                $imageContent = $response->body();
                $contentType = $response->header('Content-Type');
                $image = 'data:' . $contentType . ';base64,' . base64_encode($imageContent);
            }else{
                $image = "";
            }

            $hdimage = $user['profile_pic_url_hd'];
            // $response = Http::get($img);
            // if ($response->successful()) {
            //     // Save the image as a temporary file
            //     $imageContent = $response->body();
            //     $contentType = $response->header('Content-Type');
            //     $hdimage = 'data:' . $contentType . ';base64,' . base64_encode($imageContent);
            // }else{
            //     $hdimage = $user['profile_pic_url_hd'];
            // }


           $data = [
                'id' => $user['id'],
                'username' => $user['username'],
                'followers' => $user['edge_followed_by']['count'],
                'following' => $user['edge_follow']['count'],
                'total_posts' => $user['edge_owner_to_timeline_media']['count'],
                'hd_profile_image' => $hdimage,
                'profile_image' => $image,
                'is_video' => false,
            ];

            return response()->json(
                [
                    'success' => true,
                    'data' => $data
                ]
                , 200);
        }else{

            return response()->json([
                'success' => false,
                'message' => "Please verify human test"
            ],400);
        }
    }

    // Photo
    public function getPhoto(){
        return view("instagram.photo");
    }

    // Video
    public function getVideo(){
        return view("instagram.video");
    }

    // Video
    public function getStory(){
        return view("instagram.stories");
    }

    public function getPhotoAjax(Request $request){
        $validator = validator()->make($request->all(), [
            'url' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ],400);
        }

        $url = $request['url']; $image = "";
        $media_id = shortcode_to_mediaid($this->extractInstagramCode($url));


        $link = 'https://i.instagram.com/api/v1/clips/items/?clips_media_ids=["'.$media_id.'"]';
        $response = getCurl($link);
        $post =  $response['clips_items'][0]['media'];
        $img = $post['image_versions2']['candidates'][count($post['image_versions2']['candidates']) -1]['url'];
        $response = Http::get($img);

        if ($response->successful()) {
            // Save the image as a temporary file
            $imageContent = $response->body();
            $contentType = $response->header('Content-Type');
            $image = 'data:' . $contentType . ';base64,' . base64_encode($imageContent);
        }

        $data = [
            'id' => $post['id'],
            'username' => $post['pk'],
            'comments' => $post['comment_count'],
            'likes' => $post['like_count'],
            'shortcode' => $post['code'],
            'caption' => "",
            'hd_profile_image' => $post['image_versions2']['candidates'][0]['url'],
            'video_url' => "",
            'profile_image' => $image,
            'is_video' => false,
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }


    // Find my id
    public function findInstaId(){
        return view("instagram.findInstaId");
    }


    // Reel
    public function getReel(){
        return view("instagram.reel");
    }

    public function getStoryAjax(Request $request){ // Highlight Videos
        $validator = validator()->make($request->all(), [
            'url' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ],400);
        }

        $url = $request['url']; $image = "";
        $shortCode = $this->extractInstagramCode($url);


        $link = 'https://www.instagram.com/graphql/query/?query_hash=45246d3fe16ccc6577e0bd297a5db1ab&variables={%22highlight_reel_ids%22:[%22'.$shortCode.'%22],%22precomposed_overlay%22:false}';
        $response = getCurl($link);
         $stories =  json_decode($response)->data->reels_media[0];

        foreach ($stories->items as $story) {

            $img = $story->display_url;
            $response = Http::get($img);

            if ($response->successful()) {
                // Save the image as a temporary file
                $imageContent = $response->body();
                $contentType = $response->header('Content-Type');
                $image = 'data:' . $contentType . ';base64,' . base64_encode($imageContent);
            }
            $src = $story->is_video ? $story->video_resources[count($story->video_resources) -1]->src : $story->display_resources[count($story->display_resources) -1]->src;

            $data[] = [
                'id' => $story->id,
                'video_url' => $src,
                'profile_image' => $image,
                'is_video' => $story->is_video,
            ];
        }


        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }


    public function getProfileStoryAjax(Request $request){
        $validator = validator()->make($request->all(), [
            'url' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ],400);
        }

        $url = $request['url']; $image = "";

        list($username, $shortCode) = $this->extractInstagramStoryCode($url);

        $user = $this->scrapeUser(trim($username));
        $user_id = $user['user']['id'];
        // TODO get user id and then get story then take stories and show to the user
        $link = 'https://www.instagram.com/graphql/query/?query_hash=0a85e6ea60a4c99edc58ab2f3d17cfdf&variables={%22reel_ids%22:['.$user_id.'],%22tag_names%22:[],%22location_ids%22:[],%22highlight_reel_ids%22:[],%22precomposed_overlay%22:false,%22show_story_viewer_list%22:true,%22story_viewer_fetch_count%22:50,%22story_viewer_cursor%22:%22%22,%22stories_video_dash_manifest%22:false}';
        $response = getCurl($link);
        $stories =  json_decode($response)->data->reels_media[0];

        foreach ($stories->items as $story) {

            $img = $story->display_url;
            $response = Http::get($img);

            if ($response->successful()) {
                // Save the image as a temporary file
                $imageContent = $response->body();
                $contentType = $response->header('Content-Type');
                $image = 'data:' . $contentType . ';base64,' . base64_encode($imageContent);
            }
            $src = $story->is_video ? $story->video_resources[count($story->video_resources) -1]->src : $story->display_resources[count($story->display_resources) -1]->src;

            $data[] = [
                'id' => $story->id,
                'video_url' => $src,
                'profile_image' => $image,
                'is_video' => $story->is_video,
            ];
        }


        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }


    private function scrapeUser($username)
    {
       try{
            $response = getCurl("https://i.instagram.com/api/v1/users/web_profile_info/?username=$username");
            if ($response != null) {
                return [
                    'success' => true,
                    'user' => $response['data']['user']
                ];

            } else {
                return ['error' => 'Failed to fetch data', 'success' => false];
            }
        }catch (Exception $e){
            return [
                'success' => false,
                'message' => "fail to make call"
            ];
        }
    }

    function extractUsername($url) {
        // Parse the URL to get its path
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'];

        // Use a regular expression to extract the code
        if (preg_match('/com\/([^\/\?]+)/', $url, $matches)) {
            return $matches[1]; // The code is in the second capturing group
        }

        return null; // Return null if no code is found
    }

    function extractInstagramCode($url) {
        // Parse the URL to get its path
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'];

        // Use a regular expression to extract the code
        if (preg_match('/\/(p|reel|reels|stories\/highlights)\/([^\/\?]+)/', $path, $matches)) {
            return $matches[2]; // The code is in the second capturing group
        }

        return null; // Return null if no code is found
    }
    function extractInstagramStoryCode($url) {
        // Parse the URL to get its path
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'];

        // Use a regular expression to extract the code
        if (preg_match('/\/(p|reel|reels|stories|highlights)\/([^\/\?]+)\/([0-9]+|)/', $path, $matches)) {
            return [$matches[2],$matches[3] ?? ""]; // The code is in the second capturing group
        }

        return null; // Return null if no code is found
    }



}
