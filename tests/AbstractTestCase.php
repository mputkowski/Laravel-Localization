<?php

namespace mputkowski\Tests\Localization;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use mputkowski\Localization\Localization;
use mputkowski\Localization\ServiceProvider;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    protected function getServiceProviderClass($app)
    {
        return ServiceProvider::class;
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('localization', [
            'auto'           => true,
            'cookie_name'    => 'lang',
            'default_locale' => 'en',
            'route'          => [
                'enabled' => true,
                'pattern' => '/lang/{lang}',
            ],
        ]);
    }

    protected function getLocale($request = null)
    {
        $data = require __DIR__.'/../config/localization.php';
        $config = new Repository();
        $config->set('localization', $data);

        return new Localization($config, $request ?? new Request());
    }
}
