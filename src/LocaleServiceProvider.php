<?php

namespace mputkowski\Locale;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use mputkowski\Locale\Facades\Locale as LocaleFacade;

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
        $this->app->singleton('Locale', function () {
            $config = $this->getParameters();

            return new Locale($config);
        });

        $this->app->alias('Locale', LocaleFacade::class);

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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Locale',
        ];
    }
}
