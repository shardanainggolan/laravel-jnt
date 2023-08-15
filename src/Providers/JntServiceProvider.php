<?php

namespace Nextlogique\Jnt\Providers;

use Nextlogique\Jnt\Http\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Support\DeferrableProvider;

class JntServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind(Client::class, function (Container $app) {
            $url = $app['config']['jne.api.url'];
            $username = $app['config']['jne.api.username'];
            $key = $app['config']['jne.api.key'];

            return new Client($url, $username, $key);
        });

        $this->publishes([
            __DIR__.'/../../config/jne.php' => config_path('jne.php'),
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../config/jne.php', 'jne');
    }
}
