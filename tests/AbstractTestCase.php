<?php

namespace mputkowski\Tests\Localization;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use mputkowski\Localization\Localization;
use mputkowski\Localization\ServiceProvider;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    protected static function getServiceProviderClass(): string
    {
        return ServiceProvider::class;
    }

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

    protected function getLocalizationObject(?Request $request = null): Localization
    {
        $data = require __DIR__.'/../config/localization.php';
        $config = new Repository(['localization' => $data]);

        return new Localization($config, $request ?? new Request());
    }
}
