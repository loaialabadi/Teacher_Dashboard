<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Lecture;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        // تعريف Route Model Binding
        Route::model('lecture', Lecture::class);
    }
}
