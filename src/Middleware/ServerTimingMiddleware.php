<?php

namespace BeyondCode\ServerTiming\Middleware;

use Closure;
use Illuminate\Http\Request;
use BeyondCode\ServerTiming\ServerTiming;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ServerTimingMiddleware
{
    /** @var ServerTiming */
    protected $timing;

    /** @var float|mixed|string */
    protected $start;

    public function __construct(ServerTiming $timing)
    {
        $this->timing = $timing;
        $this->start = $this->getRequestStartTime();
    }

    public function handle(Request $request, Closure $next)
    {
        if(false === config('timing.enabled', true)) {
            return $next($request);
        }

        $this->timing->setDuration('Bootstrap', $this->getElapsedTimeInMs());

        $this->timing->start('App');

        /** @var Response $response */
        $response = $next($request);

        $this->timing->stop('App');

        $this->timing->stopAllUnfinishedEvents();

        $this->timing->setDuration('Total', $this->getElapsedTimeInMs());

        $response->headers->set('Server-Timing', $this->generateHeaders());

        return $response;
    }

    protected function getElapsedTimeInMs()
    {
        return (microtime(true) - $this->start) * 1000;
    }

    protected function getRequestStartTime()
    {
        if (defined('LARAVEL_START')) {
            return LARAVEL_START;
        }
        return $_SERVER["REQUEST_TIME_FLOAT"] ?? microtime(true);
    }

    protected function generateHeaders(): string
    {
        $header = '';

        foreach ($this->timing->events() as $eventName => $duration) {
            $eventNameSlug = Str::slug($eventName);

            $header .= "{$eventNameSlug};desc=\"{$eventName}\";";

            if (!is_null($duration)) {
                $header .= "dur={$duration}";
            }

            $header .= ", ";
        }

        return $header;
    }
}
