<?php
namespace mputkowski\Tests\Locale\Unit;

use mputkowski\Locale\Locale;
use mputkowski\Locale\LocaleServiceProvider;
use GrahamCampbell\TestBench\AbstractPackageTestCase;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    protected function getServiceProviderClass($app)
    {
        return LocaleServiceProvider::class;
    }

    protected function getLocale(array $config = [])
    {
        $default_config = include(__DIR__ . '/../../config/locale.php');
        $config = array_replace_recursive($default_config, $config);
        $config['default_locale'] = 'en';

        return new Locale($config);
    }
}