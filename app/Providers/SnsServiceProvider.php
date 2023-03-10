<?php

namespace App\Providers;

use Laravel\Socialite\SocialiteServiceProvider;

class SnsServiceProvider extends SocialiteServiceProvider
{
    /**
     * Bootstrap the service provider.
     *
     * @return void
     */
    public function boot() {
        \Socialite::extend('line', function ($app) {
            $config = $this->app['config']['services.line'];
            return \Socialite::buildProvider(LineProvider::class, $config);
        });

        \Socialite::extend('yahoo', function ($app) {
            $config = $this->app['config']['services.yahoo'];
            return \Socialite::buildProvider(YahooProvider::class, $config);
        });
    }
}
