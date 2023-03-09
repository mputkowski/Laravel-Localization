<?php

namespace mputkowski\Tests\Localization;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use mputkowski\Localization\Localization;
use mputkowski\Localization\ServiceProvider;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    /**
     * Get the service provider class.
     *
     * @return string
     */
    protected static function getServiceProviderClass(): string
    {
        return ServiceProvider::class;
    }

    /**
     * Setup the application environment.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app->config->set('localization', [
            'auto'           => true,
            'cookie_name'    => 'lang',
            'default_locale' => 'en',
            'route'          => [
                'enabled' => true,
                'pattern' => '/lang/{lang}',
            ],
        ]);
    }

    /**
     * Get fresh Localization object.
     *
     * @param \Illuminate\Http\Request|null $request
     * 
     * @return \mputkowski\Localization\Localization
     */
    protected function getLocalizationObject(?Request $request = null): Localization
    {
        $data = require __DIR__.'/../config/localization.php';
        $config = new Repository(['localization' => $data]);

        return new Localization($config, $request ?? new Request);
    }
}
