<?php

namespace mputkowski\Locale\Http\Controllers;

use mputkowski\Locale\Facades\Locale;

class LocaleController extends Controller
{
    /**
     * @param string $lang
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function changeLanguage($lang = 'default')
    {
        $cookie = Locale::setLanguage($lang, true);

        return back()->withCookie($cookie);
    }
}
