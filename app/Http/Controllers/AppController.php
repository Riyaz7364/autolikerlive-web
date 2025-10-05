<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use phpseclib3\Crypt\AES;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class AppController extends Controller
{
    private $baseUrl;

    function __construct(){
        $this->baseUrl = "http://127.0.0.1:3000/api/v1/";
    }


    // App Configuration
    private $appConfig = [
        'version' => false,
        'maintenanceMode' => false,
        'useRealFacebookLogin' => false,
        'serverUrl' => 'https://www.autolikerlive.com/app/rajeliker',
        'facebookLoginUrl' => 'https://m.facebook.com/login.php',
        'permissionUrl' => 'https://www.autolikerlive.com/app/permission'
    ];


    // Make Fake session
public function makeSession(Request $request){
    // Example data, you can replace it with real API response
    $facebookUser = [
        'id' => '100026711401432',
        'name' => 'Riyaz Saifi',
        'picture' => [
            'data' => [
                'url' => 'https://graph.fb.me/100026711401432/picture?type=large&access_token=257931075544071%7Ca19fbd5886d2081430fe02ba9e10ca7d'
            ]
        ],
        'email' => null
    ];

    $appType = 'autoliker';
    $accessToken = 'EAAF029yFLCkBPhFJAdd9WZBVfV6m95o24IzsJXHw3GVy4IZBZAIqTiCGCpmW8MXgX9eI1eqMuCzrJZB555ctLXZCM3R001Cw2G72lvCpTq83chea7okQ8daUaEpmy9dmspQcVsidHfLY8PTh9j5qoD2HNo67aTHBZAl5g66bkqIouoYaQK9Ql4Re5DVe8ZAGkdgEjtu';
    $session = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzaWQiOiIwMTk5OWE0YS0zYmNhLTcwMDAtOTJiNi03OWUzNGQwZWQ0MDMiLCJpYXQiOjE3NTkyMzAxODAsImV4cCI6MTc1OTI0ODE4MH0.QZmI7GtFn5-Xre4zPYJxHPDjRjDBBpqIt9-x_D3eeEs';

    // Save to session
    Session::put('facebook_user', [
        'id' => $facebookUser['id'],
        'name' => $facebookUser['name'],
        'email' => $facebookUser['email'] ?? 'No email provided',
        'avatar' => $facebookUser['picture']['data']['url'] ?? null,
        'app_type' => $appType,
        'logged_in_at' => now(),
        'session' => $session,
        'token' => $accessToken,
        'ip_address' => $request->ip(),
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Session created',
        'data' => Session::get('facebook_user')
    ]);
}


    /**
     * Health check endpoint
     */
    public function healthCheck()
    {
        return response()->json([
            'message' => 'RajeLiker Server is running with Laravel! 🚀',
            'version' => '1.0.0',
            'timestamp' => now()->toISOString()
        ]);
    }

    private function httpRequest($path){
        $session = Session::get('facebook_user')['session'] ?? null;
           \Log::alert($session);
        if(!$session) return;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$session,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl.$path);

        if($response->failed()){
            Session::flush();
            return null;
        }

        return $response->json(); // or $response->json() if JSON response
    }

    /**
     * Main RajeLiker page
     */
    public function rajeliker()
    {
        $user = Session::get('facebook_user');

        // Check if user should be redirected to AutoLiker dashboard
        if ($user && isset($user['token']) && isset($user['app_type']) && $user['app_type'] === 'autoliker') {

            $token = $user['token'];
            $response = Http::get(
                'https://graph.facebook.com/me',
                [
                    'access_token' => $token,
                ]
            );

            if($response->successful()) {
                $userData = $response->json();
                if(isset($userData['id'])) {
                    // Valid token, redirect to AutoLiker dashboard
                    return redirect('/app/autoliker');
                }
            }
        }




        $config = $this->appConfig;
        return view('app.rajeliker', compact('config'));
    }

    /**
     * AutoLiker Dashboard (for EAAF tokens with full permissions)
     */
    public function autolikerDashboard()
    {
        $user = Session::get('facebook_user');

        $credits = $this->httpRequest('getCredits');

        // Only allow EAAF token users
        if (!$user || !isset($user['app_type']) || $user['app_type'] !== 'autoliker' || !$credits) {
            return redirect('/app/rajeliker');
        }
        $session = Session::get('facebook_user')['session'] ?? null;

        return view('app.autoliker', compact(['user', 'credits', 'session']));
    }

    /**
     * Facebook permission page
     */
    public function permission(Request $request)
    {

        $token = $request->query('code', null);
        $headers = $request->headers->all();
        $sec_ch_token = $headers['sec-ch-token'][0] ?? '';
        $userAgent = $headers['user-agent'][0] ?? '';

        if(!$token){
          return response("
        <script>

            if (window.flutter_inappwebview && window.flutter_inappwebview.callHandler) {

                window.flutter_inappwebview.callHandler('errorFailed', 'Access denied. Missing token.');
            }
        </script>
        ")->header('Content-Type', 'text/html');
            return redirect()->route('app.index')->with('error', 'Access denied. Missing token.');
        }

        $api = "https://graph.facebook.com/v2.6/me?access_token=".$token;
        $request = Http::get($api);
        if($request->failed()){
        return "<script>
          if (window.flutter_inappwebview && window.flutter_inappwebview.callHandler) {
            window.flutter_inappwebview.callHandler('errorFailed', 'Access denied. Missing token.');
         }
        </script>";
            return redirect()->route('app.index')->with('error', 'Access denied. Invalid token.');
        }

        $user = ($request->json());

        return view('app.permission', compact(['user', 'sec_ch_token', 'userAgent', 'token']));
    }

    /**
     * Get app configuration
     */
    public function getConfig()
    {
        Log::info('📋 Config requested');
        return response()->json($this->appConfig);
    }

    /**
     * Update app configuration
     */
    public function updateConfig(Request $request)
    {
        try {
            $request->validate([
                'useRealFacebookLogin' => 'boolean',
                'facebookLoginUrl' => 'url',
                'serverUrl' => 'url'
            ]);

            if ($request->has('useRealFacebookLogin')) {
                $this->appConfig['useRealFacebookLogin'] = $request->useRealFacebookLogin;
            }
            if ($request->has('facebookLoginUrl')) {
                $this->appConfig['facebookLoginUrl'] = $request->facebookLoginUrl;
            }
            if ($request->has('serverUrl')) {
                $this->appConfig['serverUrl'] = $request->serverUrl;
            }

            // Store in cache for persistence
            Cache::put('app_config', $this->appConfig, 3600);

            Log::info('⚙️ Config updated', $this->appConfig);

            return response()->json([
                'success' => true,
                'message' => 'Configuration updated',
                'config' => $this->appConfig
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Config update error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Redirect to Facebook OAuth
     */
    public function redirectToFacebook()
    {
        // In your controller method
        $clientId = config('services.facebook.client_id');
        $redirectUri = config('services.facebook.redirect'); // raw URL, no urlencode

        $loginUrl = "https://www.facebook.com/dialog/oauth?client_id={$clientId}&redirect_uri={$redirectUri}&response_type=token";

        return redirect()->away($loginUrl);
    }

    /**
     * Handle Facebook OAuth callback
     */
    public function handleFacebookCallback(Request $request)
    {
        return view('app.facebook-callback');

    }

    /**
     * Process Facebook token (called via AJAX from the callback page)
     */
    public function processFacebookToken(Request $request)
    {
        try {
            $request->validate([
                'access_token' => 'required|string',
            ]);

            // dd(Session::get('facebook_user'));


            $accessToken = $request->access_token;
            $longLivedToken = $request->long_lived_token ?? "";
            $ua = $request->agent ?? "";

            // Detect app type based on token prefix
            $appType = 'unknown';
            $dashboardUrl = '/app/';

            if (str_starts_with($accessToken, 'EAA') && !str_starts_with($accessToken, 'EAAF')) {
                $appType = 'rajeliker';
                $dashboardUrl = '/app/'; // Analytics Dashboard
                Log::info('🔵 RajeLiker App Token Detected', ['token_prefix' => 'EAA']);
            } elseif (str_starts_with($accessToken, 'EAAF')) {
                $appType = 'autoliker';
                $dashboardUrl = '/app/autoliker'; // AutoLiker Dashboard
                Log::info('🟢 AutoLiker App Token Detected', ['token_prefix' => 'EAAF']);
            } else {
                Log::warning('🟡 Unknown Token Type', ['token_prefix' => substr($accessToken, 0, 10)]);
            }

            Log::info('🔑 Processing Facebook token', [
                'token_length' => strlen($accessToken),
                'app_type' => $appType,
                'dashboard_url' => $dashboardUrl
            ]);

            // Get user info from Facebook Graph API
            $response = Http::get('https://graph.facebook.com/me', [
                'access_token' => $accessToken,
                'fields' => 'id,name,email,picture.type(large)'
            ]);

            if (!$response->successful()) {
                Log::error('❌ Facebook API error', ['response' => $response->body()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to get user info from Facebook'
                ], 400);
            }

            $facebookUser = $response->json();
            $headers = $request->headers->all();
            $cookies = $headers['x-flutter-token'][0] ?? '';
            $userAgent = $headers['user-agent'][0] ?? '';



            // Store in cache for API access
            $userData = [
                'id' => $facebookUser['id'],
                'name' => $facebookUser['name'],
                'profilePic' => $facebookUser['picture']['data']['url'] ?? null,
                'token' => $accessToken,
                'cookies' => $cookies,
                'app_type' => $appType,
                'loginType' => 'fb',
                'fcm' => '001',
                "refer_id" => "",
                "ua" => $userAgent,
                'loginTime' => now(),
                'lastActivity' => now()
            ];

            $session = "";
            if ($appType == "autoliker") {
                $original = $this->decryptFlutterToken($cookies);
                if($original->exception != null){
                    Log::error('❌ Decrypt Flutter token error', ['error' => $original->exception]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to decrypt Flutter token. Please try again. #1'
                    ], 500);
                }

                $cookies = $this->decryptFlutterToken($cookies)->original['decrypted'];


                $api = $this->baseUrl."login";
                $apiResponse = Http::asForm()->post($api, $userData);
                $session = $apiResponse->body();
                if ($apiResponse->successful()) {
                    $loginData = $apiResponse->json();


                    if (isset($loginData['session'])) {
                        $session = $loginData['session'];

                    }else{
                          return response()->json([
                            'success' => false,
                            'message' => 'Login failed. Please try again. #2'
                        ], 500);
                    }
                }
            }


            // Log successful login
            Log::debug('✅ Facebook Login Successful', [
                'facebook_id' => $facebookUser['id'],
                'name' => $facebookUser['name'],
                'app_type' => $appType,
                'ip' => $request->ip(),
                // 'data' => $userData,
                'cookies' => $cookies,
            ]);


            Session::put('facebook_user', [
                'id' => $facebookUser['id'],
                'name' => $facebookUser['name'],
                'email' => $facebookUser['email'] ?? 'No email provided',
                'avatar' => $facebookUser['picture']['data']['url'] ?? null,
                'app_type' => $appType, // Track which app the token came from
                'logged_in_at' => now(),
                'session' => $session,
                'token' => $accessToken,
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'app_type' => $appType,
                'dashboard_url' => $dashboardUrl,
                'session' => $session,
                'user' => [
                    'id' => $facebookUser['id'],
                    'name' => $facebookUser['name'],
                    'email' => $facebookUser['email'] ?? 'No email provided',
                    'avatar' => $facebookUser['picture']['data']['url'] ?? null,
                    'app_type' => $appType
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Facebook token processing error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Login failed. Please try again. #3'
            ], 500);
        }
    }
    /**
     * Logout from Facebook session
     */
    public function facebookLogout(Request $request)
    {
        // Get user info before logout for logging
        $facebookUser = Session::get('facebook_user');

        // Clear Facebook session
        Session::forget('facebook_user');

        // Clear from cache
        if ($facebookUser) {
            Cache::forget("user_{$facebookUser['id']}");

            Log::info('Facebook Logout', [
                'facebook_id' => $facebookUser['id'],
                'name' => $facebookUser['name'],
                'ip' => $request->ip()
            ]);
        }

        return redirect()->route('app.index')->with('logout_success', 'You have been logged out successfully.');
    }

    /**
     * Get login status
     */
    public function getLoginStatus(Request $request)
    {
        $isLoggedIn = Session::has('facebook_user');
        $user = Session::get('facebook_user');

        if ($request->expectsJson()) {
            return response()->json([
                'logged_in' => $isLoggedIn,
                'user' => $isLoggedIn ? [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'avatar' => $user['avatar'],
                    'logged_in_at' => $user['logged_in_at']
                ] : null
            ]);
        }

        return response($isLoggedIn ? 'logged_in' : 'not_logged_in');
    }

    /**
     * API Login endpoint
     */
    public function apiLogin(Request $request)
    {
        try {
            $request->validate([
                'userId' => 'required|string',
                'name' => 'required|string',
                'token' => 'required|string',
                'encodedCookies' => 'required|string',
                'loginType' => 'string',
                'timestamp' => 'required',
                'userAgent' => 'string'
            ]);

            Log::info('🔐 API Login attempt for user', ['userId' => $request->userId]);

            // Decode cookies (base64 encoded)
            $decodedCookies = base64_decode($request->encodedCookies);
            if (!$decodedCookies) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid cookie data'
                ], 400);
            }

            // Store user data in cache
            $userData = [
                'userId' => $request->userId,
                'name' => $request->name,
                'profilePic' => $request->profilePic,
                'cookies' => $decodedCookies, // In production, encrypt this
                'token' => $request->token, // In production, encrypt this
                'loginType' => $request->loginType ?? 'api',
                'loginTime' => Carbon::parse($request->timestamp),
                'userAgent' => $request->userAgent,
                'lastActivity' => now()
            ];

            Cache::put("user_{$request->userId}", $userData, 3600);

            Log::info('✅ API User logged in successfully', [
                'userId' => $request->userId,
                'name' => $request->name,
                'loginType' => $request->loginType
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => [
                    'userId' => $request->userId,
                    'name' => $request->name,
                    'profilePic' => $request->profilePic,
                    'loginType' => $request->loginType,
                    'loginTime' => $request->timestamp
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('❌ API Login error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get user info
     */
    public function getUser($userId)
    {
        try {
            $user = Cache::get("user_{$userId}");

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Return only non-sensitive data
            return response()->json([
                'success' => true,
                'user' => [
                    'userId' => $user['userId'],
                    'name' => $user['name'],
                    'profilePic' => $user['profilePic'] ?? null,
                    'loginType' => $user['loginType'],
                    'loginTime' => $user['loginTime'],
                    'lastActivity' => $user['lastActivity']
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Get user error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Submit reaction
     */
    public function submitReaction(Request $request)
    {
        try {
            $request->validate([
                'postUrl' => 'required|url',
                'reaction' => 'required|in:LIKE,LOVE,CARE,HAHA,WOW,SAD,ANGRY',
                'cookies' => 'string',
                'userAgent' => 'string'
            ]);

            $authHeader = $request->header('Authorization');

            Log::info('👍 Reaction request', [
                'postUrl' => $request->postUrl,
                'reaction' => $request->reaction
            ]);

            // Validate authorization
            if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid authorization'
                ], 401);
            }

            $token = str_replace('Bearer ', '', $authHeader);

            // Find user by token in cache
            $user = null;
            $cacheKeys = Cache::get('user_tokens', []);

            foreach ($cacheKeys as $userId) {
                $userData = Cache::get("user_{$userId}");
                if ($userData && $userData['token'] === $token) {
                    $user = $userData;
                    break;
                }
            }

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid token'
                ], 401);
            }

            // Validate Facebook post URL
            if (!preg_match('/^https?:\/\/(www\.)?(facebook\.com|m\.facebook\.com|fb\.watch)\/.+/i', $request->postUrl)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Facebook post URL'
                ], 400);
            }

            // Simulate processing time
            $processingTime = rand(1, 3);
            sleep($processingTime);

            // Store reaction in cache
            $reactionId = $user['userId'] . '_' . time();
            $reactionData = [
                'id' => $reactionId,
                'userId' => $user['userId'],
                'userName' => $user['name'],
                'postUrl' => $request->postUrl,
                'reaction' => $request->reaction,
                'timestamp' => now(),
                'userAgent' => $request->userAgent,
                'status' => 'completed'
            ];

            Cache::put("reaction_{$reactionId}", $reactionData, 3600);

            // Add to user's reactions list
            $userReactions = Cache::get("reactions_{$user['userId']}", []);
            $userReactions[] = $reactionId;
            Cache::put("reactions_{$user['userId']}", $userReactions, 3600);

            Log::info('✅ Reaction processed', [
                'reactionId' => $reactionId,
                'reaction' => $request->reaction,
                'userId' => $user['userId']
            ]);

            // Simulate 90% success rate
            $success = rand(1, 10) <= 9;

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => "{$request->reaction} reaction added successfully!",
                    'reactionId' => $reactionId,
                    'timestamp' => now()->toISOString()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add reaction. Post might be private or deleted.'
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('❌ Reaction error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get user reactions
     */
    public function getUserReactions($userId)
    {
        try {
            $reactionIds = Cache::get("reactions_{$userId}", []);
            $reactions = [];

            foreach (array_slice($reactionIds, -50) as $reactionId) {
                $reaction = Cache::get("reaction_{$reactionId}");
                if ($reaction) {
                    $reactions[] = $reaction;
                }
            }

            // Sort by timestamp desc
            usort($reactions, function ($a, $b) {
                return strtotime($b['timestamp']) - strtotime($a['timestamp']);
            });

            return response()->json([
                'success' => true,
                'reactions' => $reactions,
                'count' => count($reactions)
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Get reactions error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get server stats
     */
    public function getStats()
    {
        try {
            // Get all user cache keys
            $totalUsers = 0;
            $activeUsers = 0;
            $totalReactions = 0;
            $recentReactions = 0;

            // This is a simplified version - in production, you'd want better cache management
            $cachePrefix = config('cache.prefix', '');

            $stats = [
                'totalUsers' => $totalUsers,
                'totalReactions' => $totalReactions,
                'activeUsers' => $activeUsers,
                'recentReactions' => $recentReactions,
                'serverUptime' => $this->getServerUptime(),
                'timestamp' => now()->toISOString()
            ];

            Log::info('📊 Stats requested', $stats);
            return response()->json($stats);
        } catch (\Exception $e) {
            Log::error('❌ Get stats error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get server uptime (simplified)
     */
    private function getServerUptime()
    {
        // Simple uptime calculation - you might want to store server start time
        return Cache::remember('server_start', 3600, function () {
            return now();
        })->diffInSeconds(now());
    }

    /**
     * Submit AutoLiker reaction (for EAAF tokens)
     */
    public function submitAutoLikerReaction(Request $request)
    {
        try {
            $user = Session::get('facebook_user');

            if (!$user || $user['app_type'] !== 'autoliker') {
                return response()->json([
                    'success' => false,
                    'message' => 'AutoLiker app token required'
                ], 401);
            }

            $request->validate([
                'post_url' => 'required|url',
                'reaction_type' => 'required|in:1,2,3,4,7,8,16'
            ]);

            // Validate Facebook post URL
            if (!preg_match('/^https?:\/\/(www\.)?(facebook\.com|m\.facebook\.com|fb\.watch)\/.+/i', $request->post_url)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Facebook post URL'
                ], 400);
            }

            \Log::info('🎯 AutoLiker Reaction Request', [
                'user_id' => $user['id'],
                'post_url' => $request->post_url,
                'reaction' => $request->reaction_type,
                'user' => $user
            ]);

            // TODO: Call steam bun API for chunk data

            // Store reaction record
            $reactionId = $user['id'] . '_' . time() . '_' . rand(1000, 9999);
            $reactionData = [
                'id' => $reactionId,
                'user_id' => $user['id'],
                'user_name' => $user['name'],
                'post_url' => $request->post_url,
                'post_id' => $postId,
                'reaction_type' => $request->reaction_type,
                'timestamp' => now(),
                'app_type' => 'autoliker',
                'status' => 'completed'
            ];

            Cache::put("autoliker_reaction_{$reactionId}", $reactionData, 7200); // Store for 2 hours

            // Add to user's reaction history
            $userReactions = Cache::get("autoliker_reactions_{$user['id']}", []);
            array_unshift($userReactions, $reactionId); // Add to beginning
            $userReactions = array_slice($userReactions, 0, 100); // Keep last 100
            Cache::put("autoliker_reactions_{$user['id']}", $userReactions, 7200);

            // Higher success rate for full permission tokens (95%)
            $success = rand(1, 20) <= 19;

            if ($success) {
                Log::info('✅ AutoLiker Reaction Successful', [
                    'reaction_id' => $reactionId,
                    'user_id' => $user['id']
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Reaction added successfully!',
                    'reaction_id' => $reactionId,
                    'reaction_type' => $request->reaction_type,
                    'timestamp' => now()->toISOString()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add reaction. Please try again.'
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('❌ AutoLiker reaction error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get AutoLiker user stats
     */
    public function getAutoLikerStats(Request $request)
    {
        try {
            $user = Session::get('facebook_user');

            if (!$user || $user['app_type'] !== 'autoliker') {
                return response()->json([
                    'success' => false,
                    'message' => 'AutoLiker app token required'
                ], 401);
            }

            $userReactions = Cache::get("autoliker_reactions_{$user['id']}", []);
            $totalReactions = count($userReactions);

            // Count reactions by type
            $reactionCounts = [
                'LIKE' => 0,
                'LOVE' => 0,
                'CARE' => 0,
                'HAHA' => 0,
                'WOW' => 0,
                'SAD' => 0,
                'ANGRY' => 0
            ];

            $todayCount = 0;
            $weekCount = 0;
            $today = now()->startOfDay();
            $weekAgo = now()->subWeek();

            foreach (array_slice($userReactions, 0, 50) as $reactionId) {
                $reaction = Cache::get("autoliker_reaction_{$reactionId}");
                if ($reaction) {
                    $reactionType = $reaction['reaction_type'];
                    if (isset($reactionCounts[$reactionType])) {
                        $reactionCounts[$reactionType]++;
                    }

                    $reactionTime = Carbon::parse($reaction['timestamp']);
                    if ($reactionTime->gte($today)) {
                        $todayCount++;
                    }
                    if ($reactionTime->gte($weekAgo)) {
                        $weekCount++;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'stats' => [
                    'total_reactions' => $totalReactions,
                    'today_reactions' => $todayCount,
                    'week_reactions' => $weekCount,
                    'reaction_counts' => $reactionCounts,
                    'user_info' => [
                        'name' => $user['name'],
                        'id' => $user['id'],
                        'avatar' => $user['avatar'],
                        'app_type' => 'AutoLiker Pro'
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('❌ AutoLiker stats error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Extract post ID from Facebook URL
     */


    /**
     * Get Facebook profile analytics using access token
     */
    public function getFacebookProfile(Request $request)
    {
        try {
            $user = Session::get('facebook_user');

            if (!$user || !$user['token']) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Get user profile from Facebook Graph API with basic permissions only
            $response = Http::get('https://graph.facebook.com/me', [
                'access_token' => $user['token'],
                'fields' => 'id,name,email,picture.type(large)'
            ]);

            if (!$response->successful()) {
                Log::error('Facebook API Error', ['response' => $response->body()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch Facebook data'
                ], 400);
            }

            $facebookData = $response->json();

            // Try to get posts count (may fail due to permissions)
            $postsCount = 0;
            try {
                $postsResponse = Http::get('https://graph.facebook.com/me/posts', [
                    'access_token' => $user['token'],
                    'limit' => 0,
                    'summary' => 'true'
                ]);

                if ($postsResponse->successful()) {
                    $postsData = $postsResponse->json();
                    $postsCount = isset($postsData['summary']['total_count']) ? $postsData['summary']['total_count'] : 0;
                }
            } catch (\Exception $e) {
                Log::info('Posts count not available', ['error' => $e->getMessage()]);
                $postsCount = 0;
            }

            return response()->json([
                'success' => true,
                'profile' => [
                    'id' => $facebookData['id'],
                    'name' => $facebookData['name'],
                    'email' => $facebookData['email'] ?? null,
                    'picture' => $facebookData['picture']['data']['url'],
                    'friends_count' => 0, // Not available with basic permissions
                    'posts_count' => $postsCount
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Facebook profile fetch error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get Facebook pages managed by user
     */
    public function getFacebookPages(Request $request)
    {
        try {
            $user = Session::get('facebook_user');

            if (!$user || !$user['token']) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Try to get pages managed by user (requires pages_manage_metadata permission)
            $response = Http::get('https://graph.facebook.com/me/accounts', [
                'access_token' => $user['token'],
                'fields' => 'id,name,picture,fan_count,talking_about_count,category'
            ]);

            // This will likely fail for personal accounts or without proper permissions
            if (!$response->successful()) {
                Log::info('Pages access denied or not available', ['response' => $response->body()]);
                return response()->json([
                    'success' => true,
                    'pages' => [],
                    'message' => 'No pages available or permission denied'
                ]);
            }

            $pagesData = $response->json();

            return response()->json([
                'success' => true,
                'pages' => $pagesData['data'] ?? []
            ]);
        } catch (\Exception $e) {
            Log::error('Facebook pages fetch error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => true,
                'pages' => [],
                'message' => 'Personal account - no pages to manage'
            ]);
        }
    }

    /**
     * Get Facebook post insights
     */
    public function getPostInsights(Request $request)
    {
        try {
            $user = Session::get('facebook_user');

            if (!$user || !$user['token']) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Try to get recent posts - this often fails due to privacy restrictions
            $response = Http::get('https://graph.facebook.com/me/posts', [
                'access_token' => $user['token'],
                'fields' => 'id,message,created_time,likes.summary(true),comments.summary(true),reactions.summary(true)',
                'limit' => 25
            ]);

            if (!$response->successful()) {
                Log::info('Posts access denied', ['response' => $response->body()]);
                return response()->json([
                    'success' => true,
                    'posts' => [],
                    'analytics' => [
                        'total_posts' => 0,
                        'total_likes' => 0,
                        'total_comments' => 0,
                        'total_shares' => 0,
                        'total_reactions' => 0,
                        'avg_likes_per_post' => 0,
                        'avg_comments_per_post' => 0,
                        'engagement_rate' => 0
                    ],
                    'message' => 'Posts are private or permission not granted'
                ]);
            }

            $postsData = $response->json();

            // Calculate engagement statistics
            $posts = $postsData['data'] ?? [];
            $totalLikes = 0;
            $totalComments = 0;
            $totalShares = 0;
            $totalReactions = 0;

            foreach ($posts as $post) {
                $totalLikes += isset($post['likes']['summary']['total_count']) ? $post['likes']['summary']['total_count'] : 0;
                $totalComments += isset($post['comments']['summary']['total_count']) ? $post['comments']['summary']['total_count'] : 0;
                $totalShares += isset($post['shares']['count']) ? $post['shares']['count'] : 0;
                $totalReactions += isset($post['reactions']['summary']['total_count']) ? $post['reactions']['summary']['total_count'] : 0;
            }

            return response()->json([
                'success' => true,
                'posts' => $posts,
                'analytics' => [
                    'total_posts' => count($posts),
                    'total_likes' => $totalLikes,
                    'total_comments' => $totalComments,
                    'total_shares' => $totalShares,
                    'total_reactions' => $totalReactions,
                    'avg_likes_per_post' => count($posts) > 0 ? round($totalLikes / count($posts), 2) : 0,
                    'avg_comments_per_post' => count($posts) > 0 ? round($totalComments / count($posts), 2) : 0,
                    'engagement_rate' => count($posts) > 0 ? round(($totalReactions / count($posts)) * 100, 2) : 0
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Facebook posts insights error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => true,
                'posts' => [],
                'analytics' => [
                    'total_posts' => 0,
                    'total_likes' => 0,
                    'total_comments' => 0,
                    'total_shares' => 0,
                    'total_reactions' => 0,
                    'avg_likes_per_post' => 0,
                    'avg_comments_per_post' => 0,
                    'engagement_rate' => 0
                ],
                'message' => 'Unable to access posts data'
            ]);
        }
    }


    // Save User credits to storage
    public function saveCredits(Request $request){
        //send request to server
        try{
            $response = $this->httpRequest('storeCredits');
            if($response['success']){
                toastr()->success("Credits stored success!");
                return redirect()->back();
            }
        }catch(Exception $error){
            \Log::error(json_encode([
                "source"  => "saveCredits",
                "message" => $error->getMessage(),
            ]));

            toastr()->error($error->getMessage());
            return redirect()->back();
        }

    }


private function decryptFlutterToken($token)
{
    if (!$token) {
        return response()->json(['error' => 'Missing token'], 400);
    }

    $key = 'p9X7mZ4tQ2fS6uV8yB1cE3hJ5kN7rT0w'; // must be 32 chars

    $data = base64_decode($token);
    if ($data === false) {
        return response()->json(['error' => 'Invalid base64 token'], 400);
    }

    // Extract IV (first 16 bytes) and ciphertext
    $iv = substr($data, 0, 16);
    $ciphertext = substr($data, 16);

    $aes = new AES('cbc');
    $aes->setKey($key);
    $aes->setIV($iv);

    try {
        $decrypted = $aes->decrypt($ciphertext);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Decryption failed', 'details' => $e->getMessage()], 400);
    }

    return response()->json([
        'decrypted' => $decrypted,
    ]);
}
}
