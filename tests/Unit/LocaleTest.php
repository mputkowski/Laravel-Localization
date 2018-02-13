<?php

namespace mputkowski\Tests\Locale\Unit;

class LocaleTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_parse_http_header()
    {
        $locale = $this->getLocale();

        $header = 'en,en-US;q=0.9,de;q=0.8,pl;q=0.7';
        $arr1 = $locale->getBrowserLanguages($header);
        $arr2 = [
            ['lang' => 'en', 'q' => 1.0],
            ['lang' => 'en-US', 'q' => 0.9],
            ['lang' => 'de', 'q' => 0.8],
            ['lang' => 'pl', 'q' => 0.7],
        ];

        $this->assertEquals($arr1, $arr2);
    }

    public function test_set_lang_to_default_if_requested_locale_is_not_installed()
    {
        $locale = $this->getLocale();
        $this->assertEquals('en', $locale->getCurrentLanguage());
        $locale->setLanguage('de');
        $this->assertEquals('en', $locale->getCurrentLanguage());
    }

    public function test_set_lang_method_sets_app_lang_properly()
    {
        $locale = $this->getLocale();
        $this->assertTrue($this->createLangDir('cs'));
        $locale->setLanguage('cs');
        $this->assertEquals('cs', app()->getLocale());
        $this->assertTrue($this->deleteLangDir('cs'));
    }

    public function test_set_lang_method_returns_cookie()
    {
        $locale = $this->getLocale();
        $cookie = $locale->setLanguage('en', true);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Cookie', $cookie);
    }

    public function test_cookies_are_created_with_proper_options()
    {
        $locale = $this->getLocale();
        $cookie = $locale->setLanguage('fr', true);

        $this->assertEquals('fr', $cookie->getValue());
        $this->assertTrue($cookie->isHttpOnly());
        $this->assertFalse($cookie->isSecure());
    }
}