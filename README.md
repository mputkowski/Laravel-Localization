# Laravel Localization
[![run-tests](https://github.com/mputkowski/Laravel-Localization/actions/workflows/tests.yml/badge.svg?branch=master)](https://github.com/mputkowski/Laravel-Localization/actions/workflows/tests.yml)
[![StyleCI](https://styleci.io/repos/118966076/shield)](https://styleci.io/repos/118966076)
[![Codecov](https://img.shields.io/codecov/c/github/mputkowski/Laravel-Localization.svg?style=flat-square)](https://codecov.io/gh/mputkowski/Laravel-Localization)
[![Latest Stable Version](https://img.shields.io/packagist/v/mputkowski/Laravel-Localization.svg?style=flat-square)](https://packagist.org/packages/mputkowski/Laravel-Localization)
[![Total Downloads](https://img.shields.io/packagist/dt/mputkowski/Laravel-Localization.svg?style=flat-square)](https://packagist.org/packages/mputkowski/Laravel-Localization)
[![License](https://img.shields.io/github/license/mputkowski/Laravel-Localization.svg?style=flat-square)](https://github.com/mputkowski/Laravel-Localization/blob/master/LICENSE)

Localization for Laravel

## Installation
||L6|L7|L8|L9|L10|L11|L12
|---|---|---|---|---|---|---|---|
|v4|&check;|&check;|&check;|&check;|&cross;|&cross;|&cross;|
|v5|&cross;|&cross;|&cross;|&check;|&check;|&check;|&check;|

Add package to composer.json
```
composer require mputkowski/laravel-localization
```

Publish package's config file
```
php artisan vendor:publish --provider="mputkowski\Localization\ServiceProvider"
```

### Laravel 11 or newer

Append the middleware to the `web` group in the `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \mputkowski\Localization\Middleware\VerifyLangCookie::class,
    ]);
})
```

### Laravel 10 or older

Include middleware within the `web` group in `middlewareGroups` array (`app/Http/Kernel.php`):
```php
'web' => [
    \mputkowski\Localization\Middleware\VerifyLangCookie::class,
],
```

**You don't have to register service provider and alias, this package uses Package Auto-Discovery.**

## Configuration
Configuration is stored in `config/localization.php` file.

|Key|Type|Default|
|---|---|---|
|auto|bool|true|
|cookie_name|string|`lang`|
|default_locale|string|`en`|
|**Route**||
|enabled|bool|true|
|pattern|string|`/lang/{lang}`|

### Auto-detection
If `auto` is set to `true`, the app will automatically detect client's language. The lang directory will be compared with the client's `Accept-Language` header. If header doesn't match with the app's locales, language will be set to default.

Auto-detected language could be changed by accessing a special route designed for that, or by calling the `setLocale` method:

```php
use mputkowski\Localization\Facades\Localization;

Localization::setLocale('en');
```

### Route
This package also provides routes for quick language change (url: `/lang/{lang}`, example `/lang/en`).

## Contributing
Feel free to create pull requests or open issues, I'll look on them as quick as I can.

## License
This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
```
MIT License

Copyright (c) 2018 - 2025 Michał Putkowski

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
