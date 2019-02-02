<?php

namespace App\Providers;

use Overtrue\EasySms\EasySms;
use Illuminate\Support\ServiceProvider;

class EasySmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //get easysms obj from app
        // singleton similar with bind
        $this->app->singleton(EasySms::class, function(){
            return new EasySms(config('easysms'));
        });

        //give alias for easysms class
        $this->app->alias(EasySms::class,'easysms');
    }
}
