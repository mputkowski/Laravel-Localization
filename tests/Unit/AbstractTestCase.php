<?php

namespace mputkowski\Tests\Locale\Unit;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use mputkowski\Locale\Locale;
use mputkowski\Locale\LocaleServiceProvider;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    protected function getServiceProviderClass($app)
    {
        return LocaleServiceProvider::class;
    }

    protected function getLocale(array $config = [])
    {
        $default_config = include __DIR__.'/../../config/locale.php';
        $config = array_replace_recursive($default_config, $config);

        if (!array_key_exists('default_locale', $config)) {
            $config['default_locale'] = 'en';
        }

        return new Locale($config);
    }

    protected function createLangDir($lang)
    {
        $path = app()->langPath().vsprintf('/%s', $lang);

        if (!file_exists($path)) {
            return mkdir($path);
        }
    }

    protected function deleteLangDir($lang)
    {
        $path = app()->langPath().vsprintf('/%s', $lang);

        if (file_exists($path)) {
            return rmdir($path);
        }
    }
}
