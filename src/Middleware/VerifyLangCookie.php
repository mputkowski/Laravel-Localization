<?php

namespace mputkowski\Locale\Middleware;

use Closure;
use Illuminate\Http\Response;
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
        if ($next($request) instanceof Response)
        {
            Locale::validate();
            return $next($request)->cookie(Locale::getCookie());
        }

        return $next($request);
    }
}
