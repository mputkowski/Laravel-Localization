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
        Locale::validate();
        $response = $next($request);

        if ($response instanceof Response) {
            return $response->cookie(Locale::getCookie());
        }
        else
            return $response;
    }
}
