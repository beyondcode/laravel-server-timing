<?php

namespace BeyondCode\ServerTiming\Facades;

use Illuminate\Support\Facades\Facade;

class ServerTiming extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \BeyondCode\ServerTiming\ServerTiming::class;
    }
}
