<?php

namespace mputkowski\Locale\Http\Controllers;

use mputkowski\Locale\Facades\Locale;

class LocaleController extends Controller
{
    public function changeLanguage($lang)
    {
        $cookie = Locale::setLanguage($lang, true);

        return back()->withCookie($cookie);
    }
}
