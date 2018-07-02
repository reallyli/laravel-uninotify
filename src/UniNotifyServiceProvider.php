<?php

namespace Reallyli\Uninotify;

use Illuminate\Support\ServiceProvider;

/**
 * Class UniNotifyServiceProvider
 * @package Reallyli\Uninotify
 */
class UniNotifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/uninotify.php' => config_path('uninotify.php'),
        ], 'config');
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton('uninotify', function ($app) {
            return new UniNotifyService($app['config']);
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return ['uninotify'];
    }
}