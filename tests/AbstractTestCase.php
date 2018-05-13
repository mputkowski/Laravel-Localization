<?php

namespace mputkowski\Tests\Locale;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use mputkowski\Locale\Locale;
use mputkowski\Locale\LocaleServiceProvider;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    protected function getServiceProviderClass($app)
    {
        return LocaleServiceProvider::class;
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('locale', [
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
        $data = require __DIR__.'/../config/locale.php';
        $config = new Repository;
        $config->set('locale', $data);

        return new Locale($config, $request ?? new Request);
    }
}
