<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('target_array', function ($attribute, $value, $parameters, $validator) {
            return count(array_filter($value,
                function($var) use ($parameters) {
                return ( $var && $var >= $parameters[0]);
            }));




        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
