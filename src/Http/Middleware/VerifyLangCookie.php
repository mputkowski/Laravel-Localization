<?php

namespace mputkowski\Locale\Http\Middleware;

use Closure;
use mputkowski\Locale\Facades\Locale;

class VerifyLangCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Locale::langCookieExists())
            Locale::makeCookie();
        else
            Locale::verify();

        return $next($request);
    }
}
