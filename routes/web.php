<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\SMSbomberController;
use App\Http\Controllers\Wordpress;
use App\Http\Controllers\APIController;
use App\Http\Controllers\WebAppController;
use App\Http\Controllers\DownloaderController;
use App\Http\Controllers\CopyPagesController;
use App\Http\Controllers\TikTokeIframeController;
use App\Http\Controllers\Bots\TelegramBotController;
use App\Http\Controllers\Bots\TiktokController;

use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\InstagramController;
use App\Http\Controllers\FacebookController;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\DownloadController;
use Illuminate\Support\Facades\App;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain('www.autolikerlive.com')->group(function () {

// Legal routes
require __DIR__.'/legal.php';

Route::get('/download/apk', [DownloadController::class, 'apk'])
     ->name('apk.download');



// Route::get('sw.js', function () {
//     return response()->file(public_path('sw.js'));
// });

Route::get('/free-instagram-like', function () {
    return redirect()->route('free-instagram-likes', [], 301);
});

Route::prefix('free-services')->group(function () {
    Route::get('select-service', [TiktokController::class, 'selectService'])->name('select-service-bot');
    Route::get('free-tiktok-likes/{user_id}', [TiktokController::class, 'freeTikTokLikes'])->name('free-tiktok-likes-bot');
    Route::get('free-tiktok-views/{user_id}', [TiktokController::class, 'freeTikTokViews'])->name('free-tiktok-views-bot');
    Route::get('free-instagram-likes/{user_id}', [TiktokController::class, 'freeInstagramLikes'])->name('free-instagram-likes-bot');
});


$allowedLangs = config('language.allowed_languages');

    Route::prefix('extensions')->group(function () {
        Route::get('get_token_cookie', [ListingController::class, 'get_token_cookie'])->name('get_token_cookie');
    });


    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/services', [ListingController::class, 'services'])->name('services');
    Route::get('/contact', [ContactUsController::class, 'contactUs'])->name('contact');
    Route::post('api/sendMessage', [ContactUsController::class, 'sendMessage'])->name('sendMessage');

    Route::get('/faq', function () {
        return view('faq');
    })->name('faq');

    Route::get('/privacy', function () {
        return view('privacy');
    })->name('privacy');

    Route::get('/terms', function () {
        return view('terms');
    })->name('terms');

    Route::get('/download',[ListingController::class,'download'])->name('download.page');


    Route::get('/returnpolicy', function () {
        return view('returnpolicy');
    })->name('returnpolicy');


    Route::get('/youtube_thumbnail_extractor', [APIController::class, 'youtubeTEV'])->name('youtube_thumbnail_extractor');



    Route::get('/findmyfbid', function () {
        return view('findmyfbid');
    })->name('findmyfbid');

    //  Find My FB ID
    Route::post('/findmyfbid',[WebAppController::class,'findmyfbid'])->name("searchFBID");

    Route::post('/mailbox',[APIController::class,'mailbox'])->name("mailbox");
    Route::post('/update-email',[APIController::class,'updateEmail'])->name("updateEmail");
    Route::post('/message',[APIController::class,'messages'])->name("message");
    Route::post('/delete-message',[APIController::class,'deleteMessage'])->name("delete-message");
    Route::post('/delete-mail',[APIController::class,'deleteMail'])->name("deleteMail");
    Route::get('/message/view/{id}',[APIController::class,'messageView'])->name("messageView");

    Route::get('/temp-mail', function () {
        return view('temp-mail');
    })->name('temp-mail');

    Route::get('/temp-mail-test', function () {
        return view('test.temp-mail');
    })->name('temp-mail-test');


    Route::prefix('sms-bomber-bot')->group(function () {
        Route::get('/', [App\Http\Controllers\Bots\SmsBomberBot::class, 'index']);
    });



    Route::group(['prefix' => 'web-app'], function() {
        Route::get('/', function (){

            return view('web-app.index');
        })->name('fblogin');

        Route::get('/wait-skip-ad', function(){
            return view('web-app.skip_ad');
        });

        Route::post('/checkTokenLink', [WebAppController::class, 'checkTokenLink'])->name("checkTokenLink");

        Route::get('/getDevideCode', [WebAppController::class, 'getDevideCode']);
        Route::post('/checkLogin', [WebAppController::class, 'checkLogin']);

        Route::get('/load_splash', [WebAppController::class, 'loadSplash'])
        ->name('load_splash');

        Route::post('/create_account', [TelegramBotController::class, 'createAccount'])
        ->name('create_account');

        Route::get('/dashboard', [WebAppController::class, 'dashboard'])
        ->name('dashboard')->middleware('checkFBToken');

        Route::get('/time_bonus', [WebAppController::class, 'timeBonusPage'])
        ->name('time_bonus');

        Route::get('/time_bonus_claim', [WebAppController::class, 'claimTimeBonus'])
        ->name('claimTimeBonus');

        Route::get('/referral', [WebAppController::class, 'referral'])
        ->name('referral');

        Route::post('/referral_claim', [WebAppController::class, 'referralClaim'])
        ->name('referral_claim');

        Route::get('/send_likes', [WebAppController::class, 'selectPost'])
        ->name('send_likes');
        Route::post('/send_likes_post', [WebAppController::class, 'sendLikes'])
        ->name('send_likes_post');

        Route::post('/add-job', [WebAppController::class, 'checkLink'])->name('addjob');

        Route::post('/edit-job', [WebAppController::class, 'editlink'])->name('editjob');
        Route::post('/delete-job', [WebAppController::class, 'deleteLink'])->name('deletejob');

        // Daily Bonus
        Route::get('/daily-check-in', [WebAppController::class, 'dailyCheckIn'])->name('daily_check_in');
        Route::post('/claim-daily-reward', [WebAppController::class, 'claimDailyReward'])->name('claim_daily_reward');

        Route::post('/earn-credits', [WebAppController::class, 'earnCredit'])->name('earnCredit');
        Route::get('/logout', [WebAppController::class, 'logout'])->name('logout');

    });


    Route::prefix('earn')->group(function () {
        Route::get('adCredit/{token?}', [WebAppController::class, 'adCredit'])->name('adCredit');
    });


    Route::group(['prefix' => 'tech'], function() {
        Route::get('/', [Wordpress::class, 'index'])->name("tech_index");
        Route::get('/{slug}', [Wordpress::class, 'post']);

        Route::post('/submitLink', [Wordpress::class, 'submit'])->name('submit');
        Route::post('/store', [Wordpress::class, 'storeLink'])->name('store');
    });


    Route::prefix('downloader')->group(function () {
        Route::prefix('instagram')->group(function () {
            Route::get('avatar', [DownloaderController::class, "getAvatar"])->name('instagram.avatar');
            Route::post('get_avatar', [DownloaderController::class, "getAvatarAjax"])->name('instagram.get_avatar');

            Route::get('photo', [DownloaderController::class, "getPhoto"])->name('instagram.photo');
            Route::post('get_photo', [DownloaderController::class, "getPhotoAjax"])->name('instagram.get_photo');

            Route::get('story', [DownloaderController::class, "getStory"])->name('instagram.story');
            Route::post('get_story', [DownloaderController::class, "getStoryAjax"])->name('instagram.get_story');

            Route::get('video', [DownloaderController::class, "getVideo"])->name('instagram.video');
            Route::post('get_video', [DownloaderController::class, "getPhotoAjax"])->name('instagram.get_video');

            Route::get('reel', [DownloaderController::class, "getReel"])->name('instagram.reel');

            Route::get('igtv', [DownloaderController::class, "getReel"])->name('instagram.igtv');

            Route::get('find-instagram-user-id', [DownloaderController::class, "findInstaId"])->name('instagram.findInstaId');

        });
    });

    ////// Tools


    Route::get('/call-bomber', function () {
        return view('call-bomber');
    })->name('call-bomber');


    Route::get('/youtube-auto-liker', function () {
        return view('youtube-auto-liker');
    }); // Not in use


    Route::get('/free-tiktok-views', [TiktokController::class, 'Index'])->name("free-tiktok-views");
    Route::post('/send-tiktok-views', [TiktokController::class, 'placeViewOrder'])->name("free-tiktok-views-post");

    Route::get('/free-tiktok-likes', [TiktokController::class, 'likesView'])->name("free-tiktok-likes");
    Route::post('/send-tiktok-likes', [TiktokController::class, 'placeViewOrder'])->name("free-tiktok-likes-post");

    Route::get('/free-tiktok-views-iframe', [TikTokeIframeController::class, 'Index'])->name("free-tiktok-iframe-views");
    Route::post('/send-tiktok-views-iframe', [TikTokeIframeController::class, 'placeViewOrder'])->name("free-tiktok-views-post-iframe");


    Route::get('/free-instagram-likes', [InstagramController::class, 'Index'])->name("free-instagram-likes");
    Route::post('/send-instagram-likes', [InstagramController::class, 'placeViewOrder'])->name("free-instagram-likes-post");

    // SMS Bomber WEB
    Route::get('/sms-bomber', [SMSbomberController::class, 'index'])->name("sms-bomber");
    Route::post('/send-bomber', [SMSbomberController::class, 'sendSMS'])->name('send-bomber');
    Route::post('/save-bomber', [SMSbomberController::class, 'secureNumber'])->name('save-bomber');

    Route::prefix('submit')->group(function () {
        Route::post('free-service', [TiktokController::class, 'createShortLink'])->name('submit.free-service');
        Route::post('check-order', [TiktokController::class, 'checkOrder'])->name('submit.check-order');
    });


    // Copy Pages
    Route::get('yolikers', [CopyPagesController::class, 'yolikers'])->name('yolikers');
    Route::get('djliker', [CopyPagesController::class, 'djliker'])->name('djliker');
    Route::get('machineliker', [CopyPagesController::class, 'machineliker'])->name('machineliker');

    // END

    Route::get('{fbsub}',[ListingController::class,'fbsub'])
    ->where('fbsub', '(?i)fbsub') // Case-insensitive match
    ->name('login');

    Route::get('{slug}', [ListingController::class, 'IgCommentLiker'])
    ->where('slug', '(?i)instagram-comment-liker') // Case-insensitive match
    ->name('IgCommentLiker');

    Route::prefix('auto-liker-1000-likes')->group(function () {
        Route::get('/', [FacebookController::class, 'autoliker'])->name('autoliker.facebook');
        Route::post('/login', [FacebookController::class, 'login'])->name('login.facebook');
    });

    // Instagram Auto Liker
    Route::prefix('auto-liker-instagram')->group(function () {
        Route::get('/', [InstagramController::class, 'autoLikerInstagram'])->name('autoliker.instagram');
        Route::post('login', [InstagramController::class, 'loginWithUsername'])->name('autoliker.login');

        Route::get('getUserData', [InstagramController::class, 'getUserData']);
    });


    Route::prefix('auto-liker')->group(function () {
        Route::middleware(['auth'])->group(function () {
            Route::get('dashboard', [InstagramController::class, 'dashboard'])->name('autoliker.dashboard');

            Route::get('boost', [InstagramController::class, 'boost'])->name('autoliker.boost');
            Route::post('boost_submit', [InstagramController::class, 'boostSubmit'])->name('autoliker.boost.submit');

            Route::get('view', [InstagramController::class, 'view'])->name('autoliker.view');
            Route::post('view-update', [InstagramController::class, 'viewUpdate'])->name('autoliker.view.update');

            Route::get('earn', [InstagramController::class, 'earn'])->name('autoliker.earn');
            Route::post('earn-load', [InstagramController::class, 'loadEarnLink'])->name('autoliker.earn.load');
            Route::post('earn-check', [InstagramController::class, 'earnCheck'])->name('autoliker.earn.check');
            Route::post('claim-bonus', [InstagramController::class, 'claimBonus'])->name('autoliker.claim.daily.bonus');

            Route::get('free-likes', [InstagramController::class, 'freeLikes'])->name('autoliker.free.likes');
            Route::get('free-views', [InstagramController::class, 'freeViews'])->name('autoliker.free.views');
            Route::get('free-ig-views', [InstagramController::class, 'freeIGViews'])->name('autoliker.free.ig.views');

            Route::get('settings', [InstagramController::class, 'settings'])->name('autoliker.settings');
            Route::post('settings-update', [InstagramController::class, 'updateSettings'])->name('autoliker.settings.update');

        });
    });




    Route::get('/{keyword?}', [ListingController::class,'index'])->name('index');



// Redirect if a language is set in the URL
Route::get('{lang}/{any}', function ($lang, $any) use ($allowedLangs) {
    if (in_array($lang, $allowedLangs)) {
        return redirect("/{$any}", 301);
    }

    abort(404);
})->where([
    'lang' => implode('|', $allowedLangs),
    'any' => '.*'
]);


});


