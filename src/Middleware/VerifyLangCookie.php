<?php

namespace mputkowski\Locale\Middleware;

use Closure;
use mputkowski\Locale\Facades\Locale;

class VerifyLangCookie
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Locale::validate();

        return $next($request)->cookie(Locale::getCookie());
    }
}
