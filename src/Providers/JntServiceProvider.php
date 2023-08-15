<?php

namespace Nextlogique\Jnt\Providers;

use Nextlogique\Jnt\Http\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\DeferrableProvider;

class JntServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        $configPath = __DIR__ . '/../../config/jnt.php';
        $this->publishes([$configPath => config_path('jnt.php')], 'jnt');
    }

    public function register() : void
    {
        $configPath = __DIR__ . '/../../config/jnt.php';
        $this->mergeConfigFrom($configPath, 'jnt');

        $this->app->bind(Client::class, function (Container $app) {
            $url = $app['config']['jnt.api.url'];
            $username = $app['config']['jnt.api.username'];
            $key = $app['config']['jnt.api.key'];

            return new Client($url, $username, $key);
        });
    }
}
