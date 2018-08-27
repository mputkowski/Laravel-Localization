<?php

namespace mputkowski\Localization\Middleware;

use Closure;
use Illuminate\Http\Response;
use mputkowski\Localization\Facades\Localization;

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
        Localization::validate();
        $response = $next($request);

        if ($response instanceof Response) {
            return $response->cookie(Localization::getCookie());
        } else {
            return $response;
        }
    }
}
