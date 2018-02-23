<?php

namespace webSocket\Providers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class WebsocketServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath(__DIR__.'/../config/config.php');
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('websocket.php')], 'config');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('websocket');
        }
        $this->mergeConfigFrom($source, 'websocket');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}