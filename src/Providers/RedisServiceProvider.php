<?php
/**
 * Created by PhpStorm.
 * User: WanZengchuang
 * Date: 2017/7/27
 * Time: 17:23
 */

namespace webSocket\Providers;

use Illuminate\Support\Arr;
use webSocket\Redis\RedisManagerCli;

class RedisServiceProvider extends \Illuminate\Redis\RedisServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('redis', function ($app) {
            $config = $app->make('config')->get('database.redis');

            return new RedisManagerCli(Arr::pull($config, 'client', 'predis'), $config);
        });

        $this->app->bind('redis.connection', function ($app) {
            $config = $app->make('config')->get('websocket.redis_connection', 'default');
            return $app['redis']->connection($config);
        });
    }
}