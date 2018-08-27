<?php

namespace mputkowski\Localization;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use mputkowski\Localization\Facades\Localization as LocalizationFacade;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/localization.php' => config_path('localization.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Localization', function (Container $app) {
            $config = $app['config'];
            $request = $app['request'];

            return new Localization($config, $request);
        });

        $this->app->alias('Localization', LocalizationFacade::class);

        if (config('localization.route.enabled', true)) {
            $route = config('localization.route.pattern', '/lang/{lang}');

            $callback = function ($lang) {
                $localization = $this->app->make('Localization');
                $localization->setLocale($lang);
                $cookie = $localization->getCookie();

                return back()->withCookie($cookie);
            };

            $this->app['router']
                ->get($route, $callback)
                ->middleware('web')
                ->name('localization');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'Localization',
        ];
    }
}
