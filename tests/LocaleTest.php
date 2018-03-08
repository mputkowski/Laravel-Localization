<?php
namespace mputkowski\Tests\Locale;

use Illuminate\Http\Request;

class LocaleTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();

        $path = app()->langPath().'/de';

        if (!file_exists($path)) {
            return mkdir($path);
        }
    }

    protected function tearDown()
    {
        parent::tearDown();

        $path = app()->langPath().'/de';

        if (file_exists($path)) {
            return rmdir($path);
        }
    }

    public function test_property_overloading()
    {
        $locale = $this->getLocale();
        $locale->default_locale = 'zh';
        $this->assertEquals('zh', $locale->default_locale);
    }

    public function test_get_browser_languages()
    {
        $request = new Request;
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

    public function test_set_lang_method()
    {
        $locale = $this->getLocale();
        $cookie = $locale->setLocale('de');

        $this->assertEquals('de', $locale->getLocale());
    }
}
