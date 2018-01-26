<?php

namespace mputkowski\Locale;

use Cookie;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class Locale
{
    /**
     * Default app language.
     *
     * @var string
     */
    public $default;

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->default = Config::get('app.locale');
    }

    /**
     * Check if app language is the same as value of language cookie.
     *
     * @return void
     */
    public function verify()
    {
        if ($this->getCookie() !== App::getLocale()) {
            App::setLocale($this->getCookie());
        }
    }

    /**
     * Set app language.
     *
     * @param string $lang
     */
    public function setLanguage($lang = 'default')
    {
        $code = ($lang === 'default') ? $this->default : $lang;

        App::setLocale($code);
        Cookie::queue(cookie()->forever($this->getCookieName(), $code));
    }

    /**
     * Make lang cookie.
     *
     * @return void
     */
    public function makeCookie()
    {
        if ($this->setAutomatically()) {
            return $this->setLanguage($this->getPreferedLanguage());
        }

        return $this->setLanguage();
    }

    /**
     * Get current app language.
     *
     * @return string
     */
    public function getCurrentLanguage()
    {
        return App::getLocale();
    }

    /**
     * Get browser languages from http header.
     *
     * @return array
     */
    public function getBrowserLanguages()
    {
        $header = explode(',', request()->header('Accept-Language'));
        $langs = [];

        foreach ($header as $lang) {
            $data = explode(';', $lang);
            array_push($langs, [
                'lang' => $data[0],
                'q'    => (isset($data[1])) ? (float) str_replace('q=', '', $data[1]) : 1.0,
            ]);
        }

        return $langs;
    }

    /**
     * Get language code by comparing browser language and app languages.
     *
     * @return string
     */
    private function getPreferedLanguage()
    {
        //Browser's current language is in index 0
        $lang = $this->getBrowserLanguages()[0]['lang'];

        if (strpos($lang, '-') !== false) {
            if ($this->langDirExists($lang)) {
                return $lang;
            }

            $codes = explode('-', $lang);

            foreach ($codes as $code) {
                if ($this->langDirExists($code)) {
                    return $code;
                }
            }
        }

        return ($this->langDirExists($lang)) ? $lang : $this->default;
    }

    /**
     * Get language cookie value.
     *
     * @return string
     */
    public function getCookie()
    {
        return Cookie::get($this->getCookieName());
    }

    /**
     * Check if language cookie is set.
     *
     * @return bool
     */
    public function langCookieExists()
    {
        return Cookie::has($this->getCookieName());
    }

    /**
     * Check if app supports specified language.
     *
     * @param string $dir
     *
     * @return bool
     */
    private function langDirExists($dir)
    {
        return file_exists(App::langPath().vsprintf('/%s', $dir));
    }

    /**
     * Get 'auto' config value.
     *
     * @return string
     */
    private function setAutomatically()
    {
        return Config::get('locale.auto', true);
    }

    /**
     * Get 'cookie_name' config value.
     *
     * @return string
     */
    private function getCookieName()
    {
        return Config::get('locale.cookie_name', 'lang');
    }
}
