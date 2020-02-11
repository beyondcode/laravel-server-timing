<?php

namespace BeyondCode\ServerTiming;

use Illuminate\Support\ServiceProvider;

class ServerTimingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(ServerTiming::class, function ($app) {
            return new ServerTiming(new \Symfony\Component\Stopwatch\Stopwatch());
        });
    }

    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('timing.php'),
        ], 'server-timing-config');
    }
}
