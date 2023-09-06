<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;

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
        Validator::extend('katakana', function ($attribute, $value, $parameters, $validator) {
            return(preg_match("/^[ァ-ヶ一]+/u", $value));
        });

        Paginator::useBootstrap();
    }
}
