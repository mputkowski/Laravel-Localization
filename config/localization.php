<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Automatically detect client's language
    |--------------------------------------------------------------------------
    |
    | If true, the app will automatically detect client's language.
    | The lang directory will be compared with the client's Accept-Language header.
    | If the header doesn't match with the app's locales, language will be set to default.
    |
    */
    'auto' => true,

    /*
    |--------------------------------------------------------------------------
    | Cookie name
    |--------------------------------------------------------------------------
    |
    | Name of the cookie which stores the current language setting.
    |
    */
    'cookie_name' => 'lang',

    /*
    |--------------------------------------------------------------------------
    | Default locale
    |--------------------------------------------------------------------------
    |
    | Fallback language for the "auto" feature.
    |
    */
    'default_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Route for changing locale
    |--------------------------------------------------------------------------
    |
    | enabled - boolean
    | pattern - string
    |
    */
    'route' => [
        'enabled' => true,
        'pattern' => '/lang/{lang}',
    ],
];
