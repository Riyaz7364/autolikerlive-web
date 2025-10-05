<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Wordpress;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\TiktokController;
use App\Http\Controllers\WebAppController;
use App\Http\Controllers\Bots\SmsBomberBot;
use App\Http\Controllers\TradingController;
use App\Http\Controllers\TempMailController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\DownloaderController;
use App\Http\Controllers\Bots\AutolikerLiveBot;
use App\Http\Controllers\AppController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes
Route::prefix('app')->name('api.')->group(function () {
    // App Configuration
    Route::get('/config', [AppController::class, 'getConfig'])->name('config');

    // Authentication
    Route::post('/auth/login', [AppController::class, 'apiLogin'])->name('auth.login');

    // Reactions
    Route::post('/reactions', [AppController::class, 'submitReaction'])->name('reactions.submit');

    // Stats
    Route::get('/stats', [AppController::class, 'getStats'])->name('stats');

    Route::post('/test', [AppController::class, 'decryptFlutterToken'])->name('encrypt.test');

});

Route::post("/check-installer-license", function () {
    $response = [
        "status" => true,
        "message" => "License key is valid.",
        "license_key" => "8fe9afbd-2f23-43bf-a60c-1e262dfe2d1c",
    ];

    return response()->json($response);
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('/activatePremium', [APIController::class,'activatePremium']);
    Route::post('/checkPremium', [APIController::class,'checkPremium']);
    Route::post('/startPremium', [APIController::class,'startPremium']);
    Route::post('/add-job', [WebAppController::class, 'checkLink']);
    Route::post('/getSession', [Wordpress::class, 'createSession'])->name('createSession');
    Route::post('/getOrders', [Wordpress::class, 'getOrders'])->name('getOrders');
    Route::post('/setTimer', [Wordpress::class, 'setTimer'])->name('setTimer');

    Route::post('/getInstagramUser', [InstagramController::class, 'getUserData']);

    // Check cookies
    Route::post('/checkCookies', [APIController::class, 'checkCookies']);


    // Route::post('/delete-message',[APIController::class,'deleteMessage'])->name("delete-message");




});

Route::prefix('telegram')->group(function () {
    Route::post('/webhook_autolikerlive', [AutolikerLiveBot::class, 'webhook']);
    Route::post('/webhook_sms_bomber', [SmsBomberBot::class, 'webhook']);
    // Route::post('/createTekegramLink', function(){
    //     echo "Wroking";
    // });
});


Route::prefix('forex')->group(function () {
    Route::post('/webhook', [TradingController::class, 'webhook']);
    Route::get('/check_open_trade', [TradingController::class, 'checkOpenTrade']);

});


Route::prefix('downloader')->group(function () {
    Route::prefix('instagram')->group(function () {
        Route::post('get_avatar', [DownloaderController::class, "getAvatarAjax"]);
        Route::post('get_photo', [DownloaderController::class, "getPhotoAjax"]);
        Route::post('get_story', [DownloaderController::class, "getStoryAjax"]);
        Route::post('get_video', [DownloaderController::class, "getPhotoAjax"]);
        Route::post('get_profileStory', [DownloaderController::class, "getProfileStoryAjax"]);
        // Route::post('sendFile', [TelegramBotController::class, "sendFile"]);
    });
});


