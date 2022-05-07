<?php

namespace BeyondCode\ServerTiming\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \BeyondCode\ServerTiming\ServerTiming start(string $key) Start a unique timed event.
 * @method static \BeyondCode\ServerTiming\ServerTiming addMetric(string $metric) Add new event with null duration.
 * @method static bool hasStartedEvent(string $key) Check if a event has been created already.
 * @method static \BeyondCode\ServerTiming\ServerTiming measure(string $key) Stop existing event and record its duration, else start a new event.
 * @method static \BeyondCode\ServerTiming\ServerTiming stop(string $key) Stop a timed event and record its duration.
 * @method static void stopAllUnfinishedEvents() Stop all running events.
 * @method static \BeyondCode\ServerTiming\ServerTiming setDuration(string $key, float|int|callable $duration) Set the duration for an event if $duration is number, else record elapsed time to run a user function if $duration is callable.
 * @method static float|int|null getDuration(string $key) Retrieve the duration an event has taken.
 * @method static array events() Get the list of finished events with their associated duration.
 *
 * @see \BeyondCode\ServerTiming\ServerTiming
 */
class ServerTiming extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \BeyondCode\ServerTiming\ServerTiming::class;
    }
}
