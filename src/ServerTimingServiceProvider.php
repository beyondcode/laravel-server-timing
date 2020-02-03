<?php

namespace BeyondCode\ServerTiming;

use Illuminate\Support\ServiceProvider;

class ServerTimingServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(ServerTiming::class, function ($app) {
            return new ServerTiming(new \Symfony\Component\Stopwatch\Stopwatch());
        });
    }
}
