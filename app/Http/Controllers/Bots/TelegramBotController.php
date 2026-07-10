<?php

namespace App\Http\Controllers\Bots;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Wordpress;
use App\Models\TiktokTimer;
use App\Models\UniqueLink;
use App\Http\APIHelper;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\TelegramMessage;
use App\Models\User;
class TelegramBotController extends Controller
{
//     protected $telegram_api_url;

//     public function __construct()
//     {
//         $this->telegram_api_url = "https://api.telegram.org/bot7301015849:AAGLUJTzUbxOmazgp2MTlKilhg7NB25SfGA/";
//     }

//     public function webhook(Request $request)
//     {
//         $update = $request->all();
//         // return ($update);
//         if (isset($update['message']) || isset($update['edited_message'])) {
//             $this->handleMessage($update['message'] ?? $update['edited_message']);
//         }

//         // Get the request data
//         $data = $request->all();

//         // Convert the data to JSON or another format if needed
//         $jsonData = json_encode($data);

//         // Save the request data to storage
//         // Storage::disk('local')->put('requests/saveFile_' . time() . '.json', $jsonData);
//         return response('OK', 200);
//     }

//     public function createAccount(Request $request){
//         $validator = validator($request->all(), [
//             'id' => "required",
//             'username' => "required",
//         ]);

//         if($validator->fails()){
//             return response()->json([
//                 'success' => false,
//                 'message' => "Authentication failed Error: 1021",
//             ]);
//         }



//         $response = Http::asForm()->post($this->telegram_api_url. "getUserProfilePhotos", [
//             "user_id" => $request['id'],

//         ]);
//         $json = $response->json();

//         if($json['ok']){
//             if(isset($json['result']['photos']) && isset($json['result']['photos'][0]) && isset($json['result']['photos'][0][1])){
//                 $file_id = $json['result']['photos'][0][1]['file_id'];
//                 $response = Http::asForm()->post($this->telegram_api_url. "getFile", [
//                     "file_id" => $file_id,
//                 ]);
//                 $json = $response->json();
//                 $file_path = $json['result']['file_path'];
//                 $image_url = "https://api.telegram.org/file/bot7301015849:AAGLUJTzUbxOmazgp2MTlKilhg7NB25SfGA/".$file_path;

//             }else{
//                 $image_url = "https://cdn-icons-png.flaticon.com/512/3273/3273898.png";
//             }
//         }else{
//             $image_url = "https://cdn-icons-png.flaticon.com/512/3273/3273898.png";
//         }

//         $user = [
//             'chat_id' => $request['id'],
//             'name'    => $request['username'],
//             'email'   => $request['id']."bot@tg.com",
//             'password'=> $request['id'],
//             'country'=> "TG",
//             'tglogin'=> 1,
//             "ref_id" => $request['ref_id'] ?? "18",
//             'image'   => $image_url,
//         ];

//         $api = APIHelper::path('login');
//         $response = Http::asForm()->post($api, $user);
//         $json = $response->json();
//         if($json['success'] == true){
//             \Session::put('my_json_data', $json);
//             $this->setLocalUser($user);
//             return redirect()->to('/web-app/');
//         }else{
//             $api = APIHelper::path('register');
//             $response = Http::asForm()->post($api, $user);
//             $json = $response->json();
//             if($json['success']){
//                 \Session::put('my_json_data', $json);
//                 $this->setLocalUser($user);
//                 return redirect()->to('/web-app/');
//             }
//         }

//         toastr()->error("Authentication failed Error: 1023");
//         return redirect()->back()->withInput();
//     }

//     private function setLocalUser($user){
//         $existingUser = User::where('email', $user['email'])->first();
//         if ($existingUser) {
//             auth()->login($existingUser);
//         } else {
//             // Create a new user and log them in
//             $newUser = new User();
//             $newUser->name = $user['name'];
//             $newUser->email = $user['email'];
//             $newUser->save();
//             auth()->login($newUser);
//         }
//     }

//     protected function handleMessage($message){

//     $chat_id = $message['chat']['id'];
//     $text = $message['text'];

//     if ($text === '/start_auto_liker' || $text === '/start') {

//         $message =
// <<<EOD
// 🚀 Boost Your Facebook Posts with Auto Likes! 👍

// 💬 Want more likes on your Facebook posts? Use the Facebook Auto Liker Bot to get instant likes! 💥 Follow these simple steps to start boosting your posts in seconds:

// 🔗 How it works:

// 🔑 Login with your Facebook Access Token. (Don’t have one? We'll guide you!)
// 📋 Send the Facebook post link you want to boost.
// 🎯 Watch the likes roll in with just a tap!
// 💡 Quick, Easy, and Safe – No reactions, only likes. Try it out today!

// ⚡️ Note: This bot only adds likes, no reactions.
// EOD;
//     // $this->sendMessage($chat_id, $message);
//     // return;
//     $button = "Start Auto Liker - https://t.me/autolikerlive_bot/Fbsub";
//     $this->broadcastMessage($chat_id, $message, $button, false);

//     }elseif ($text === '/instagram_downloader') {

//     $message =
// <<<EOD
// ✨ Download Instagram Reels Easily! ✨

// Want to save Instagram Reels to your phone or computer? It\'s super simple with Autoliker Live Tools – a free and fast tool! Here\'s how:

// 1️⃣ Choose the Instagram Reels video you want to download.

// 2️⃣ Copy the URL/Link of the video from Instagram.

// 3️⃣ Open the Instagram Downloader Bot.

// 4️⃣ Paste the copied link into the input box.

// 5️⃣ Hit the "Download Video" button and save the Reels video to your device!

// Now you can enjoy Reels offline anytime! 🚀
// EOD;
//         $button = "Start Instagram Downloader - https://instatool.autolikerlive.com/#/homePgae";
//         $this->broadcastMessage($chat_id, $message, $button, true);
//         }elseif ($text === '/instagram_downloader_forword_to_channel') {
//             if(TelegramMessage::where('chat_id', $chat_id)->exists()){
//                 TelegramMessage::where('chat_id', $chat_id)->delete();
//             }
//             // $text_array = explode(trim($text), "<buttons>");
//             $this->sendMessage($chat_id, "Type the channel username [@] required");
//             $message = new TelegramMessage;
//             $message->chat_id = $chat_id;
//             $message->save();
//         }elseif(TelegramMessage::where('chat_id', $chat_id)->where('status', 0)->exists() && preg_match('/^@[\w]+$/',$text)){
//             $this->sendMessage($chat_id, "Enter your post content");
//             $message = TelegramMessage::where('chat_id', $chat_id)->first();
//             $message->chat_id_other = $text;
//             $message->save();
//         }elseif(TelegramMessage::where('chat_id', $chat_id)->where('status', 0)->exists()) {
//             $reply_message = "Something is wrong";
//             $message = TelegramMessage::where('chat_id', $chat_id)
//             ->where('message', null)
//             ->first();
//         //    return $this->instagramApp("@autolikerlive", $message->message, $message->links);
//            $links = TelegramMessage::where('chat_id', $chat_id)
//             ->where('message','!=', null)
//             ->where('links', null)
//             ->first();
//             if($message){
//                 $reply_message = <<<EOD
//                 Add Button Follow the example
//                 Button text 1 - http://www.example.com/
//                 Button text 2 - http://www.example2.com/
//                 Button text 3 - http://www.example3.com/
//                 EOD;
//                 $message->message = $text;
//                 $message->save();
//             }elseif($links){
//                 if($text == ""){
//                     $reply_message = "Post send to channel";
//                     $links->links = 1;
//                     $links->status = 1;
//                     $links->delete();
//                     $this->broadcastMessage($links->chat_id_other, $links->message, $links->links, false);
//                     return;

//                 }
//                 elseif($this->validateButtonTextLinks($text)){
//                     $reply_message = "Post send to channel";
//                     $links->links = $text;
//                     $links->status = 1;
//                     $links->delete();
//                     $this->broadcastMessage($links->chat_id_other, $links->message, $links->links, false);
//                     return;

//                 }else{
//                     $reply_message = <<<EOD
//                     Invalid Format - Follow the example
//                     Button text 1 - http://www.example.com/
//                     Button text 2 - http://www.example2.com/
//                     Button text 3 - http://www.example3.com/
//                     EOD;
//                 }


//             }
//             $this->sendMessage($chat_id, $reply_message);
//         }
//     }

//     function validateButtonTextLinks($text)
//     {
//         $single_line = str_replace('\n', "\n", $text);
//         $clear_text = str_replace('\/', "/", $single_line);
//         // Split text into lines
//         $lines = explode("\n", trim($clear_text));

//         // Regular expression to validate "<button name> - <valid URL>"
//         $regex = '/^([a-zA-Z-0-9 \s]+) - ([^\s]+)?$/';

//         // Check if each line matches the pattern
//         foreach ($lines as $line) {
//             if (preg_match($regex, trim($line), $match)) {
//             	if(!filter_var($match[2], FILTER_VALIDATE_URL)){
//             		return false;
//             	}
//             }
//         }

//         return count($lines) >= 0;  // Ensure there are at least 3 valid entries
//     }

//     protected function extractButtons($text, $webapp)
//     {
//         $unescapedText = stripslashes($text);
//         $unescapedText = str_replace('\n', "\n", $unescapedText);
//         $lines = explode("\n", trim($unescapedText));
//         $regex = '/^([a-zA-Z-0-9 \s]+) - ([^\s]+)?$/';
//         $buttons = [];
//         foreach ($lines as $line) {
//             if (preg_match($regex, trim($line))) {
//                 list($buttonText, $url) = explode(' - ', trim($line));
//                 if($webapp){
//                     $button[] = [
//                         'text' => $buttonText,
//                         'web_app' => ['url' => $url]
//                     ];
//                 }else{
//                     $button[] = [
//                         'text' => $buttonText,
//                         'url' => $url
//                     ];
//                 }

//                 $buttons[] = $button;
//                 $button = [];
//             } else {
//                 return false;
//             }
//         }
//         return $buttons;
//     }

//     function broadcastMessage($chatId, $chat_message, $buttons, $webapp = false)
//     {
//         $client = new Client();
//         $buttons = $this->extractButtons($buttons, $webapp);
//         $keyboard = [
//             "inline_keyboard" =>
//                 $buttons

//         ];
//         $data = [
//             'chat_id' => $chatId,
//             'text' => $chat_message,
//             'reply_markup' => json_encode($keyboard)
//         ];
//         $client->post($this->telegram_api_url . 'sendMessage', ['json' => $data]);
//     }



//     protected function sendMessage($chat_id, $text)
//     {
//         $client = new Client();
//         $client->post($this->telegram_api_url . 'sendMessage', [
//             'json' => [
//                 'chat_id' => $chat_id,
//                 'text' => $text,
//             ]
//         ]);
//     }

//     function sendWebAppButton($chatId, $buttonText) {
//         $client = new Client();

//         $keyboard = [
//             "keyboard" =>
//             [
//                 ["FB Liker", "TikTok Views"],["TikTok Likes"],

//                 // [
//                 //     [
//                 //         "text" => "TikTok Likes",
//                 //         "web_app" => ["url" => "https://www.autolikerlive.com"]
//                 //     ],
//                 // ]
//                 ],
//                 "resize_keyboard" => true,
//                 "one_time_keyboard" => false,
//         ];

//         $data = [
//             'chat_id' => $chatId,
//             'text' => 'Click the button to launch the mini app!',
//             'reply_markup' => json_encode($keyboard)
//         ];

//         $client->post($this->telegram_api_url . 'sendMessage',[ 'json' => $data]);
//     }


//     public function sendFile(Request $request) {


//         // // Get the request data
//         // $data = $request->all();

//         // // Convert the data to JSON or another format if needed
//         // $jsonData = json_encode($data);

//         // // Save the request data to storage
//         // Storage::disk('local')->put('requests/saveFile_' . time() . '.json', $jsonData);

//         $client = new Client();

//         $chatId = $request['chat_id'];
//         $fileUrl = $request['link'];
//         $isVideo = $request['is_video'];
//         // Choose the correct API endpoint based on the file type
//         $apiMethod = $isVideo ? 'sendVideo' : 'sendDocument';

//         // Create the payload to send the file
//         $data = [
//             'chat_id' => $chatId,
//             'caption' => $caption ?? 'Here is your file!',
//             $isVideo ? 'video' : 'document' => $fileUrl
//         ];

//         $client->post($this->telegram_api_url . $apiMethod, ['json' => $data]);

//     }




//     protected function processTikTokLink($chat_id, $tiktok_link)
//     {

//         $response_data = $this->createTekegramLink($tiktok_link, $chat_id);
//         if ($response_data['success']) {
//             $follow_up_link = $response_data['link'];
//             $this->sendMessage($chat_id, 'Please follow this link: ' . $follow_up_link);
//             $this->sendMessage($chat_id, 'Please return here after visiting the link.');
//             // Set timer in the database or session
//             $this->setUserState($chat_id, $response_data['code'], now());

//             // Schedule a job to check the timer
//             dispatch(new \App\Jobs\CheckTimerJob($chat_id));
//         } else {
//             $this->sendMessage($chat_id, 'Error: ' . $response_data['message']);
//         }
//     }
//     protected function createTekegramLink($video_link, $chat_id){

//         if(preg_match('/https?:\/\/[^\/]+\.tiktok\.com\/([^\/?]+)/', $video_link, $match)){
//             $video_code = $match[1];
//         }else{
//             return [
//                 'success' => false,
//                 "message" => "Invlaid Video Link."];
//         }

//         // return redirect()->back()->withErrors(["msg" => "Out of fund - Please come back tommorow"]);

//         // Check if the link was used recently
//         $tiktokTimer = TiktokTimer::where('link', $video_code)
//             ->where('updated_at', '>=', Carbon::now()->subMinutes(10))
//             ->first();

//         if ($tiktokTimer) {
//             // Calculate remaining time
//             $remaining_seconds = Carbon::now()->diffInSeconds($tiktokTimer->updated_at->addMinutes(10));
//             $minutes = floor($remaining_seconds / 60);
//             $seconds = $remaining_seconds % 60;

//             return [
//                 'success' => false,
//                 'message' => "Please wait $minutes minutes and $seconds seconds before adding the same link again."
//             ];
//         }

//         $session = uniqid();

//         $data = [
//             'link' => $video_link,
//             'ip' => $chat_id,
//             'type' => "FREE_TIKTOK",
//             'video_id' => $video_code,
//         ];


//     	$tech_post = Post::inRandomOrder()->first();
//     	$slug = $tech_post->slug;
//         $uniqueLink = new UniqueLink();
//         $uniqueLink->session = $session;
//         $uniqueLink->user_id = 0;
//         $uniqueLink->order_id = 0;
//         $uniqueLink->status = 0;
//         $uniqueLink->ip = $chat_id;
//         $uniqueLink->data = $data;
//         $uniqueLink->save();
//         $url = "https://l.facebook.com/l.php?u=https://autolikerlive.com/tech/$slug?usg=$session";

//         return [
//             'success' => true,
//             'link' => $url,
//             'code' => $video_code
//         ];
//     }

//     protected function setUserState($chat_id, $state, $timestamp)
//     {
//         TiktokTimer::updateOrCreate(
//             ['id' => $chat_id],
//             ['link' => $state, 'timer' => time()+900]
//         );
//     }
}
