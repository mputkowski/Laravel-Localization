<?php

namespace mputkowski\Locale;

use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/locale.php' => config_path('locale.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        AliasLoader::getInstance()->alias('Locale', \mputkowski\Locale\Facades\Locale::class);
        App::bind('Locale', function () {
            return new Locale();
        });

        if (Config::get('locale.lang_routes'))
        {
            $this->app['router']->group(['namespace' => 'mputkowski\Locale\Http\Controllers'], function () {
                require __DIR__.'/Http/routes.php';
            });
        }
    }
}
