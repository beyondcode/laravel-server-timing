<?php

use BeyondCode\ServerTiming\ServerTiming;

if (!function_exists('measure_timing')) {
    function measure_timing(string $key, $callable = null)
    {
        /** @var ServerTiming $timing */
        $timing = app(ServerTiming::class);

        if (is_callable($callable)) {
            $timing->setDuration($key, $callable);
            return;
        }

        $timing->measure($key);
    }
}
