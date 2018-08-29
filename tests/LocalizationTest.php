<?php

namespace mputkowski\Tests\Localization;

use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use mputkowski\Localization\Localization;

class LocalizationTest extends AbstractTestCase
{
    protected $locales = ['de', 'fr', 'it', 'pl'];

    protected function setUp()
    {
        parent::setUp();

        foreach ($this->locales as $locale) {
            $path = $this->langPath($locale);

            if (!file_exists($path)) {
                mkdir($path);
            }
        }
    }

    protected function tearDown()
    {
        parent::tearDown();

        foreach ($this->locales as $locale) {
            $path = $this->langPath($locale);

            if (file_exists($path)) {
                rmdir($path);
            }
        }
    }

    protected function langPath($locale)
    {
        return app()->langPath().vsprintf('/%s', $locale);
    }

    /**
     * @expectedException \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @expectedExceptionMessage Missing localization config
     */
    public function test_constructor_throws_exception_if_config_is_missing()
    {
        $config = new Repository();

        return new Localization($config, new Request());
    }

    public function test_property_overloading()
    {
        $locale = $this->getLocale();
        $locale->default_locale = 'zh';
        $this->assertEquals('zh', $locale->default_locale);
    }

    public function test_get_request_method_is_the_same_as_provided()
    {
        $request = new Request();
        $request->headers->set('Accept-Language', 'pl,fr;q=0.8,de;q=0.7,en;q=0.6');
        $request->cookies->set('lang', 'en');
        $locale = $this->getLocale($request);

        $this->assertEquals($request, $locale->getRequest());
        $this->assertEquals($request->cookies->get('lang'), $locale->getCookie()->getValue());
    }

    public function test_validate_method_sets_locale()
    {
        $request = new Request();
        $request->cookies->set('lang', 'it');
        $locale = $this->getLocale($request);

        $locale->validate();

        $this->assertEquals('it', $locale->getLocale());
    }

    public function test_get_browser_languages()
    {
        $request = new Request();
        $request->headers->set('Accept-Language', 'en,en-US;q=0.9,de;q=0.8,pl;q=0.7');
        $locale = $this->getLocale($request);

        $arr1 = $locale->getBrowserLanguages();
        $arr2 = [
            ['locale' => 'en', 'quality' => 1.0],
            ['locale' => 'en-US', 'quality' => 0.9],
            ['locale' => 'de', 'quality' => 0.8],
            ['locale' => 'pl', 'quality' => 0.7],
        ];

        $this->assertEquals($arr1, $arr2);
    }

    public function test_preferred_language()
    {
        $request = new Request();
        $request->headers->set('Accept-Language', 'fr,de;q=0.9,pl;q=0.8');
        $locale = $this->getLocale($request);

        $lang = $locale->getPreferredLanguage();
        $this->assertEquals('fr', $lang);
    }

    public function test_set_lang_method()
    {
        $locale = $this->getLocale();
        $cookie = $locale->setLocale('de');

        $this->assertEquals('de', $locale->getLocale());
    }

    public function test_locale_route()
    {
        $request = Request::create('lang/pl', 'GET');
        $route = last(app('router')->getRoutes()->get());

        $response = $route->bind($request)->run();
        $cookie = last($response->headers->getCookies());

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('pl', $cookie->getValue());
    }
}
