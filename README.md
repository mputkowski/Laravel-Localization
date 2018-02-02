# Laravel Locale
[![Travis branch](https://img.shields.io/travis/rust-lang/rust/master.svg?style=flat-square)](https://travis-ci.org/mputkowski/laravel-locale)
[![StyleCI](https://styleci.io/repos/118966076/shield)](https://styleci.io/repos/118966076)
[![Latest Stable Version](https://poser.pugx.org/mputkowski/laravel-locale/v/stable?format=flat-square)](https://packagist.org/packages/mputkowski/laravel-locale)
[![Total Downloads](https://poser.pugx.org/mputkowski/laravel-locale/downloads?format=flat-square)](https://packagist.org/packages/mputkowski/laravel-locale)
[![License](https://poser.pugx.org/mputkowski/laravel-locale/license?format=flat-square)](https://packagist.org/packages/mputkowski/laravel-locale)

Powerful Localization for Laravel 5

## Installation
Add package to composer.json
```
composer require mputkowski/laravel-locale
```
Publish package's config file
```
php artisan vendor:publish
```
In `config/app.php`, add the following to `providers` array:
```
'providers' => [
    ...
    ...
    ...
    mputkowski\Locale\LocaleServiceProvider::class,
],
```
And register alias in `aliases` array:
```
'aliases' => [
    ...
    ...
    ...
    'Locale' => mputkowski\Locale\Facades\Locale::class,
],
```
Include middleware within the `web` group in `middlewareGroups` array (`app/Http/Kernel.php`):
```
'web' => [
    ...
    ...
    ...
    \mputkowski\Locale\Http\Middleware\VerifyLangCookie::class,
],
```

## Contributing
Feel free to create pull requests or open issues, I'll look on them as quick as I can.

## License
This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
