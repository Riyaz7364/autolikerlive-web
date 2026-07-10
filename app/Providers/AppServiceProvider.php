<?php

namespace App\Providers;

use App\SmsManager;
use App\CallManager;
use Illuminate\Support\ServiceProvider;
use App\CallSources\Onecard;
use App\SmsSources\A23;
use App\SmsSources\Housing;
use App\SmsSources\Doubtnut;
use App\SmsSources\Cuemath;
use App\SmsSources\Byjus;
use App\SmsSources\SamsungShop;
use App\SmsSources\Unacademy;
use App\SmsSources\Wakefit;

use App\SmsSources\Sheba;
use App\SmsSources\Jslglobal;
use App\SmsSources\Bdcabs;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SmsManager::class, function ($app){
            $smsSources = [
                91 => [
                    new Wakefit(false),
                    new Unacademy(true),
                    new Wakefit(false),
                    new Unacademy(true),
                    new SamsungShop(true),
                    new Byjus(false),
                    new Cuemath(true),
                    new Doubtnut(false),
                    new Housing(false),
                    new A23(true),
                ],
                880 => [
                    new Sheba(true),
                    new Jslglobal(false),
                    new Bdcabs(true),
                ],

            ];
            return new SmsManager($smsSources);
        });

        $this->app->bind(CallManager::class, function ($app){
            $callSources = [
                new Onecard(true),
            ];

            return new CallManager($callSources);
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
