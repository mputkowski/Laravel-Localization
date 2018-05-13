<?php

namespace mputkowski\Tests\Locale;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use mputkowski\Locale\Middleware\VerifyLangCookie;

class MiddlewareTest extends AbstractTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function test_middleware_validates_cookie()
    {
        $response = (new VerifyLangCookie())->handle(new Request, function () {
            return new Response;
        });

        $cookie = $response->headers->getCookies();
        $cookie = reset($cookie);

        $this->assertSame('en', $cookie->getValue());
    }

    public function test_middleware_handles_all_types_of_response()
    {
        $response = (new VerifyLangCookie())->handle(new Request, function () {
            return new FooBar;
        });

        $this->assertInstanceOf(FooBar::class, $response);
    }
}

class FooBar
{

}