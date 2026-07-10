<?php

namespace App\Http\Controllers;

use App\APIs\InstaApi;
use App\Models\Link;
use App\Models\TiktokTimer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class BoostServiceController extends Controller
{
    private $api;

    function __construct(InstaApi $instaAPI)
    {
        $this->api = $instaAPI;
    }

    /**
     * Handle boost submissions for fixed-10 likes/reactions.
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link' => 'required',
            'type' => 'required',
            'service_type' => 'required',
            'service_node' => 'required',
        ]);

        $user = Auth::user();

        $post_id = $request['link'];
        $actor_id = null;
        $query = "";

        $service_type = $request['service_type'];
        $service_node = $request['service_node'];

        if ($validator->fails()) {
            toastr()->error('Please fill in all required fields.');
            return redirect()->back();
        }

        // Only accept full URLs for this flow
        if (!preg_match('/(?:facebook|fb)/i', $post_id) && !preg_match('/^https?:\/\//i', $post_id)) {
            toastr()->error('Please provide a valid full fb URL (https://...)');
            return redirect()->back();
        }

        if (preg_match('/\/share\/([^\/]+)/i', $post_id)) {
            $response = Http::get($post_id);
            if ($response->successful()) {
                $finalUrl = (string) $response->effectiveUri();
                $query = parse_url($finalUrl, PHP_URL_QUERY);
                parse_str($query, $params);
                $post_id = urldecode($params['next'] ?? '');
                \Log::debug("Final URL after HTTP request: " . $post_id);

                // Check is final url is a post link
                if (preg_match('/\/story\.php/i', $post_id)) {
                    $query = parse_url($post_id, PHP_URL_QUERY);

                    parse_str($query, $uri);

                    $fb_story_id = $uri['story_fbid'] ?? null;
                    $actor_id = $uri['id'] ?? null;


                    \Log::debug('Parsed URI Parameters: ' . print_r($uri, true));
                    \Log::debug('FB Story ID: ' . $fb_story_id);
                    \Log::debug('Actor ID: ' . $actor_id);
                }
            }
        }
        // Turnstile verification
        $g_api = "https://challenges.cloudflare.com/turnstile/v0/siteverify";
        $response = Http::asForm()->post($g_api, [
            'secret' => '0x4AAAAAABUvrqmCFqU8nDsRuy_uFGiovRU',
            'response' => $request['cf-turnstile-response'] ?? null,
            'remoteip' => $request->header('cf-connecting-ip'),
        ]);

        $json = $response->json();

        if (empty($json['success']) || $json['success'] != true) {
            toastr()->error("Human verification failed");
            return redirect()->back();
        }

        // Rate limit: 10 minutes per user (by IP)

        if (TiktokTimer::where('id', $user['uid'])
                ->where('updated_at', '>=', Carbon::now()->subMinutes(10))
                ->exists()
        ) {
            toastr()->error('Please wait 10 minutes before submitting again.');
            return redirect()->back();
        }

        // dd(TiktokTimer::where('id', $user['uid'])->get());

        $data = [
            'link' => $post_id,
            'uid' => $user['uid'],
            'limit' => 10,
            'service' => $service_type,
            'loginType' => $user['loginType'],
        ];

        if (!isset($fb_story_id) && $service_node == 'fbpost') {
            // Check link belong to user
            $uri = parse_url($post_id);
            $userData = $this->api->getFB($uri['path'], $service_node);
            \Log::debug('API Url Path:' . $uri['path']);
            \Log::debug('User Data from API:' . print_r($userData, true));

            if (isset($userData['data']['story_token'])) {
                $postID = $userData['data']['story_token'];
            } elseif (isset($userData['data']['comet_ufi_summary_and_actions_renderer-multi'][0]['feedback']['id'])) {
                $id64 = $userData['data']['comet_ufi_summary_and_actions_renderer-multi'][0]['feedback']['id'];
                $postID = explode(':', base64_decode($id64))[1];
            } else {
                toastr()->error('Invalid or private post link');
                return redirect()->back();
            }

            $data['link'] = $postID;
            $id = $userData['data']['props']['actorID'];
            if ($id == $user['uid']) {
                // $data['edge_count'] = $userData['data']['comet_ufi_summary_and_actions_renderer-multi'][0]['feedback']['reaction_count']['count'];
                $data['edge_count'] = 0;
            } else {
                toastr()->error('You can only add a link posted by the ' . $user['username']);
                return redirect()->back();
            }
        } else {
            $data['edge_count'] = 0;
            // $post_id was set above to the resolved 'next' URL (or story URL). Use that
            // as the link to send to the provider instead of the temporary $query string.
            $data['link'] = $query;
            if ($service_node != 'fbuser' && $actor_id != $user['uid']) {
                toastr()->error('You can only add a link posted by the ' . $user['username']);
                return redirect()->back();
            }
        }

        $serviceMap = [4825, 3758, 164];

        $type = $request->input('type');
        $service_type = $request->input('service_type');

        $service_id = in_array((int)$type, $serviceMap, true) ? (int)$type : null;

        if (!$service_id) {
            toastr()->error('Selected service is not supported for this flow');
            return redirect()->back();
        }

        $config = match ($service_type) {
            'followers' => ['quantity' => 10, 'wait' => 60],
            'reactions' => ['quantity' => 10, 'wait' => 60,],
            default => ['quantity' => 10, 'wait' => 60],
        };


        $quantity = $config['quantity'];
        $wait = $config['wait'];
        $data['limit'] = $quantity;


        // Prepare data payload (provider/key values can be changed in one place)
        $key = 'fef081d0d82d678f3d64c3a5cc190179';
        $api = 'https://smmsocialmedia.in/api/v2';

        // Ensure we remove any `share_url` query parameter from the final link
        if (strpos($post_id, 'share_url=') !== false) {
            $parts = parse_url($post_id);
            $qs = [];
            if (!empty($parts['query'])) {
                parse_str($parts['query'], $qs);
            }
            if (isset($qs['share_url'])) {
                unset($qs['share_url']);
                $newQuery = http_build_query($qs);
                $clean = '';
                if (!empty($parts['scheme'])) {
                    $clean .= $parts['scheme'] . '://';
                }
                if (!empty($parts['host'])) {
                    $clean .= $parts['host'];
                }
                $clean .= $parts['path'] ?? '';
                if ($newQuery) {
                    $clean .= '?' . $newQuery;
                }
                if (!empty($parts['fragment'])) {
                    $clean .= '#' . $parts['fragment'];
                }
                $post_id = $clean;
                \Log::debug('Cleaned post link (removed share_url): ' . $post_id);
            }
        }

        // Prepare payload for provider API (avoid reusing variable names like $query)
        $payload = [
            'key' => $key,
            'action' => 'add',
            'service' => $service_id,
            'link' => $post_id,
            'quantity' => $quantity,
        ];

        \Log::debug('Boost Service Request Data: ' . print_r($payload, true));

        $response = Http::asForm()->post($api, $payload);
        if ($response->failed()) {
            toastr()->error('Failed to connect to boost service provider');
            return redirect()->back();
        }

        $responseData = $response->json();
        $data['order_id'] = $responseData['order'] ?? null;

        $this->saveTimer($request, $post_id, $wait, $user['uid']);

        Link::create($data);
        toastr()->success('Promotion started success!');
        return redirect()->back();
    }

    private function saveTimer(Request $request, $link, $wait = 10, $user_id = null)
    {
        $userIp = $user_id;
        $currentTime = time();
        $timerExpiration = $currentTime + $wait * 60;

        // Save or update timer data in the database
        TiktokTimer::updateOrCreate(['id' => $userIp], ['timer' => $timerExpiration, 'link' => $link]);

        // You can customize the response as needed
        return response()->json(['message' => 'Timer saved successfully']);
    }
}
