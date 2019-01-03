# Laravel Localization
[![Travis branch](https://img.shields.io/travis/mputkowski/Laravel-Localization/master.svg?style=flat-square)](https://travis-ci.org/mputkowski/Laravel-Localization)
[![StyleCI](https://styleci.io/repos/118966076/shield)](https://styleci.io/repos/118966076)
[![Codecov](https://img.shields.io/codecov/c/github/mputkowski/Laravel-Localization.svg?style=flat-square)](https://codecov.io/gh/mputkowski/Laravel-Localization)
[![Latest Stable Version](https://img.shields.io/packagist/v/mputkowski/Laravel-Localization.svg?style=flat-square)](https://packagist.org/packages/mputkowski/Laravel-Localization)
[![Total Downloads](https://img.shields.io/packagist/dt/mputkowski/Laravel-Localization.svg?style=flat-square)](https://packagist.org/packages/mputkowski/Laravel-Localization)
[![License](https://img.shields.io/github/license/mputkowski/Laravel-Localization.svg?style=flat-square)](https://github.com/mputkowski/Laravel-Localization/blob/master/LICENSE)

Powerful Localization for Laravel 5

## Installation
Add package to composer.json
```
composer require mputkowski/laravel-localization
```
Publish package's config file
```
php artisan vendor:publish --provider="mputkowski\Localization\ServiceProvider"
```
Include middleware within the `web` group in `middlewareGroups` array (`app/Http/Kernel.php`):
```php
'web' => [
    \mputkowski\Localization\Middleware\VerifyLangCookie::class,
],
```
**You don't have to register service provider and alias, this package uses Package Auto-Discovery.**

### Manual installation
```
composer require mputkowski/laravel-localization
```
In `config/app.php`, add the following to `providers` array:
```php
'providers' => [
    mputkowski\Localization\ServiceProvider::class,
],
```
And register alias in `aliases` array:
```php
'aliases' => [
    'Localization' => mputkowski\Localization\Facades\Localization::class,
],
```
```
php artisan vendor:publish --provider="mputkowski\Localization\ServiceProvider"
```
Include middleware within the `web` group in `middlewareGroups` array (`app/Http/Kernel.php`):
```php
'web' => [
    \mputkowski\Localization\Middleware\VerifyLangCookie::class,
],
```

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
If `auto` is set to `true`, app will automatically detect client's language. Directories in `resources/lang` will be compared with client's `Accept-Language` header. If header doesn't match with app's locales, language will be set to default. 

### Route
This package also provides routes for quick language change (url: `/lang/{lang}`, example `/lang/en`).

## Contributing
Feel free to create pull requests or open issues, I'll look on them as quick as I can.

## License
This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
```
MIT License

Copyright (c) 2018 Michał Putkowski

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
