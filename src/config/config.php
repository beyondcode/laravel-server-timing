<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel Server Timing enabled
    |--------------------------------------------------------------------------
    |
    | This configuration is used to enable the server timing measurement,
    | if set to false, the middleware will be bypassed
    |
    */

    'enabled' => env('ENABLE_SERVER_TIMING', 'true') === 'true' ?? false,
];
