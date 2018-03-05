<?php

namespace mputkowski\Tests\Locale\Unit;

use Illuminate\Http\Request;
use mputkowski\Locale\Http\Middleware\VerifyLangCookie;

class MiddlewareTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testRedirectMiddlewareCalled()
    {
        $request = Request::create('http://example.com', 'GET', [], ['lang' => 'fr']);

        $locale = $this->getLocale();
        $middleware = new VerifyLangCookie();
        $response = $middleware->handle($request, function () {});
        
        $lang = $locale->getCurrentLanguage();
        $this->assertEquals('fr', $lang);
    }
}
