<?php

namespace App\Providers;
use App\Models\Lecture;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Route;
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
            Route::model('lecture', Lecture::class);


            $this->app->singleton(\Faker\Generator::class, function () {
        return FakerFactory::create('ar_EG'); // أو 'ar_EG' أو حسب رغبتك
    });
    Paginator::useBootstrapFive(); // لتفعيل دعم Bootstrap 5
    }
}
