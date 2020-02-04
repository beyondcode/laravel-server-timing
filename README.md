# Laravel Server Timings

[![Latest Version on Packagist](https://img.shields.io/packagist/v/beyondcode/laravel-server-timing.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-server-timing)
[![Build Status](https://img.shields.io/travis/beyondcode/laravel-server-timing/master.svg?style=flat-square)](https://travis-ci.org/beyondcode/laravel-server-timing)
[![Quality Score](https://img.shields.io/scrutinizer/g/beyondcode/laravel-server-timing.svg?style=flat-square)](https://scrutinizer-ci.com/g/beyondcode/laravel-server-timing)
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

By default, the middleware measures only three things, to keep it as light-weight as possible:

- Bootstrap (time before the middleware gets called)
- Application time (time to get a response within the app)
- Total (total time before sending out the response)

## Adding additional measurements

If you want to provide additional measurements, you can use the start and stop methods. If you do not explicitly stop a measured event, the event will automatically be stopped once the middleware receives your response. This can be useful if you want to measure the time your Blade views take to compile.

```php
ServerTiming::start('Running expensive task');

// do something

ServerTiming::stop('Running expensive task');
```

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
