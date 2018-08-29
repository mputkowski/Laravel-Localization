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

        $this->app->alias(Localization::class, LocalizationFacade::class);

        if (config('localization.route.enabled', true)) {
            $this->registerRoute();
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

    /**
     * Get callback for locale route
     *
     * @return callback
     */
    private function getRouteCallback()
    {
        return function ($lang) {
            $localization = app('Localization');
            $localization->setLocale($lang);
            $cookie = $localization->getCookie();

            return back()->withCookie($cookie);
        };
    }

    /**
     * Register route for locale change
     *
     * @return void
     */
    private function registerRoute()
    {
        $route = config('localization.route.pattern', '/lang/{lang}');

        $this->app['router']
            ->get($route, $this->getRouteCallback())
            ->middleware('web')
            ->name('localization');
    }
}
