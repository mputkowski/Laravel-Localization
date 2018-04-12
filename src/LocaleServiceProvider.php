<?php

namespace mputkowski\Locale;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Request;
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
        $this->app->singleton('locale', function (Container $app) {
            $config = $app['config'];
            $request = Request::instance();

            return new Locale($config, $request);
        });

        $this->app->alias('locale', LocaleFacade::class);

        if (config('locale.route.enabled', true)) {
            $route = config('locale.route.pattern', '/lang/{lang}');

            $this->app['router']->get($route, function ($lang) {
                $locale = $this->app['locale'];
                $locale->setLocale($lang);
                $cookie = $locale->getCookie();

                return back()->withCookie($cookie);
            })->middleware('web')->name('locale');
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
            'locale',
        ];
    }
}
