<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Faker\Factory as FakerFactory;

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
            $this->app->singleton(\Faker\Generator::class, function () {
        return FakerFactory::create('ar_EG'); // أو 'ar_EG' أو حسب رغبتك
    });
    Paginator::useBootstrapFive(); // لتفعيل دعم Bootstrap 5
    }
}
