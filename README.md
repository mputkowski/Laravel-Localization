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
php artisan vendor:publish --provider="mputkowski\Locale\LocaleServiceProvider"
```
Include middleware within the `web` group in `middlewareGroups` array (`app/Http/Kernel.php`):
```php
'web' => [
    //
    //
    //
    \mputkowski\Locale\Http\Middleware\VerifyLangCookie::class,
],
```
**You don't have to register service provider and alias, this package uses Package Auto-Discovery.**

### Manual installation
```
composer require mputkowski/laravel-locale
```
In `config/app.php`, add the following to `providers` array:
```php
'providers' => [
    //
    //
    //
    mputkowski\Locale\LocaleServiceProvider::class,
],
```
And register alias in `aliases` array:
```php
'aliases' => [
    //
    //
    //
    'Locale' => mputkowski\Locale\Facades\Locale::class,
],
```
```
php artisan vendor:publish --provider="mputkowski\Locale\LocaleServiceProvider"
```
Include middleware within the `web` group in `middlewareGroups` array (`app/Http/Kernel.php`):
```php
'web' => [
    //
    //
    //
    \mputkowski\Locale\Http\Middleware\VerifyLangCookie::class,
],
```

## Configuration
Configuration is stored in `config/locale.php` file, it contains:
* `auto` (type: `bool`, default: `true`)
* `cookie_name` (type: `string`, default: `'lang'`)
* `routes` (type: `bool`, default: `true`)

### Auto-detection
If `auto` is set to `true`, app will automatically detect client's language. Directories in `resources/lang` will be compared with client's `Accept-Language` header. If header doesn't match with app's locales, language will be set to default (value of `locale` in `config/app.php`). 

### Routes
This package also provides routes for quick language change (url: `/lang/{lang}`, example `/lang/en`).

## Contributing
Feel free to create pull requests or open issues, I'll look on them as quick as I can.

## License
This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
