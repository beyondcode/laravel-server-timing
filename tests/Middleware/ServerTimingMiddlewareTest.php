<?php

namespace BeyondCode\ServerTiming\Tests\Middleware;

use BeyondCode\ServerTiming\Middleware\ServerTimingMiddleware;
use BeyondCode\ServerTiming\ServerTiming;
use Illuminate\Http\Request;
use Orchestra\Testbench\TestCase;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\HttpFoundation\Response;

class ServerTimingMiddlewareTest extends TestCase
{
    /** @test */
    public function it_add_server_timing_header()
    {
        $request = new Request;

        $timing = new ServerTiming(new Stopwatch());

        $middleware = new ServerTimingMiddleware($timing);

        $response = $middleware->handle($request, function ($req) {
            return new Response();
        });

        $this->assertArrayHasKey('server-timing', $response->headers->all());

    }

    /** @test */
    public function it_is_bypassed_if_configuration_false()
    {
        $this->app['config']->set('timing.enabled', false);

        $request = new Request;

        $timing = new ServerTiming(new Stopwatch());

        $middleware = new ServerTimingMiddleware($timing);

        $response = $middleware->handle($request, function ($req) {
            return new Response();
        });

        $this->assertArrayNotHasKey('server-timing', $response->headers->all());
    }
}
