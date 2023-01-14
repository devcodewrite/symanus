<?php

namespace App\Providers;

use App\Notifications\SMSChannel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Notification::extend('sms', function ($app) {
            return new SMSChannel();
        });
    }
}
