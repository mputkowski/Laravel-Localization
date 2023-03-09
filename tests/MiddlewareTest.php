<?php

namespace mputkowski\Tests\Localization;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use mputkowski\Localization\Middleware\VerifyLangCookie;

class MiddlewareTest extends AbstractTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_middleware_validates_cookie()
    {
        $response = (new VerifyLangCookie())->handle(new Request(), function () {
            return new Response;
        });

        $cookie = $response->headers->getCookies();
        $cookie = reset($cookie);

        $this->assertSame('en', $cookie->getValue());
    }

    public function test_middleware_handles_all_types_of_response()
    {
        $response = (new VerifyLangCookie())->handle(new Request(), function () {
            return new FooBar;
        });

        $this->assertInstanceOf(FooBar::class, $response);
    }
}

class FooBar
{
}
