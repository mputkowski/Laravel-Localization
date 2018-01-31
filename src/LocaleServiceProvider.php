<?php

namespace mputkowski\Locale;

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
            return new Locale($this->getParameters());
        });

        if (config('locale.routes', true)) {
            $this->app['router']->group(['namespace' => 'mputkowski\Locale\Http\Controllers'], function () {
                require __DIR__.'/Http/routes.php';
            });
        }
    }

    protected function getParameters()
    {
        return [
            'auto'           => config('locale.auto', true),
            'cookie_name'    => config('locale.cookie_name', 'lang'),
            'default_locale' => config('app.locale', 'en'),
            'routes'         => config('locale.routes', true),
        ];
    }
}
