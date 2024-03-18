# Laravel Server Timings

[![Latest Version on Packagist](https://img.shields.io/packagist/v/beyondcode/laravel-server-timing.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-server-timing)
[![Total Downloads](https://img.shields.io/packagist/dt/beyondcode/laravel-server-timing.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-server-timing)

Add Server-Timing header information from within your Laravel apps.

## Installation

You can install the package via composer:

```bash
composer require beyondcode/laravel-server-timing
```

## Usage

To add server-timing header information, you need to add the `\BeyondCode\ServerTiming\Middleware\ServerTimingMiddleware::class,` middleware to your HTTP Kernel.
In order to get the most accurate results, put the middleware as the first one to load in the middleware stack.

### Laravel 11
`bootstrap/app.php`
```php
return Application::configure(basePath: dirname(__DIR__))
    // ...
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(\BeyondCode\ServerTiming\Middleware\ServerTimingMiddleware::class);
    })
    // ...
    ->create();
```

### Laravel 10 and below
`app/Http/Kernel.php`
```php
class Kernel extends HttpKernel
{
    protected $middleware = [
        \BeyondCode\ServerTiming\Middleware\ServerTimingMiddleware::class,
        // ...
    ];
```

---

By default, the middleware measures only three things, to keep it as light-weight as possible:

- Bootstrap (time before the middleware gets called)
- Application time (time to get a response within the app)
- Total (total time before sending out the response)

Once the package is successfully installed, you can see your timing information in the developer tools of your browser. Here's an example from Chrome:

![CleanShot 2024-03-18 at 13 48 53@2x](https://github.com/beyondcode/laravel-server-timing/assets/26432041/adea40e4-5c34-4aee-9fb7-ad6bac40addc)

## Adding additional measurements

If you want to provide additional measurements, you can use the start and stop methods. If you do not explicitly stop a measured event, the event will automatically be stopped once the middleware receives your response. This can be useful if you want to measure the time your Blade views take to compile.

```php
use BeyondCode\ServerTiming\Facades\ServerTiming;

ServerTiming::start('Running expensive task');

// Take a nap
sleep(5);

ServerTiming::stop('Running expensive task');
```

![CleanShot 2024-03-18 at 13 51 56@2x](https://github.com/beyondcode/laravel-server-timing/assets/26432041/47e9e692-2bce-4449-a7ea-966fa4701cdb)


If you already know the exact time that you want to set as the measured time, you can use the `setDuration` method. The duration should be set as milliseconds:

```php
ServerTiming::setDuration('Running expensive task', 1200);
```

In addition to providing milliseconds as the duration, you can also pass a callable that will be measured instead:


```php
ServerTiming::setDuration('Running expensive task', function() {
    sleep(5);
});
```

## Adding textual information

You can also use the Server-Timing middleware to only set textual information without providing a duration.

```php
ServerTiming::addMetric('User: '.$user->id);
```

## Publishing configuration file

The configuration file could be published using:
`php artisan vendor:publish --tag=server-timing-config`

You can disable the middleware by changing the `timing.enabled` configuration to false or adding `SERVER_TIMING_ENABLED=false` to your `.env` file.

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email marcel@beyondco.de instead of using the issue tracker.

## Credits

- [Marcel Pociot](https://github.com/mpociot)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
