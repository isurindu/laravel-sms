<?php

namespace Isurindu\LaravelSms;

use Illuminate\Support\ServiceProvider;
use Isurindu\LaravelSms\Gateways\GatewayManager;

class LaravelSmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/sms.php' => config_path('sms.php'),
        ]);
        $this->app->singleton('sms', function ($app) {
            return new GatewayManager;
        });
    }
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/Config/sms.php',
            'sms'
        );
    }
}
