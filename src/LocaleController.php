<?php

namespace mputkowski\Locale;

use Illuminate\Routing\Controller;
use mputkowski\Locale\Facades\Locale;

class LocaleController extends Controller
{
    /**
     * Set language.
     *
     * @param string $lang
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setLanguage($lang)
    {
        Locale::setLocale($lang);
        $cookie = Locale::getCookie();

        return back()->withCookie($cookie);
    }
}
