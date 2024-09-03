<?php

namespace App\Providers;

use App\Models\Calendar;
use App\Observers\CalendarObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Calendar::observe(CalendarObserver::class);
    }
}
