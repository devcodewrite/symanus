<?php

namespace App\Providers;

use App\Models\Attendance;
use App\Models\Bill;
use App\Models\Classes;
use App\Models\Fee;
use App\Models\FeeType;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;
use App\Notifications\SMSChannel;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Notification;
use View;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

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
