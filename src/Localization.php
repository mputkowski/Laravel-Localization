<?php

namespace mputkowski\Localization;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

class Localization
{
    /**
     * The Repository instance.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    private $config;

    /**
     * The language cookie.
     *
     * @var null|\Symfony\Component\HttpFoundation\Cookie
     */
    private $cookie = null;

    /**
     * The Request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Languages supported by user's browser.
     *
     * @var array
     */
    private $browserLanguages = [];

    /**
     * Create a new Localization instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Illuminate\Http\Request                $request
     *
     * @return void
     */
    public function __construct(Config $config, Request $request)
    {
        $config = $config->get('localization');

        if (!is_array($config)) {
            throw new \Exception('Missing localization config');
        }
        $this->config = $config;
        $this->request = $request;

        $cookie_value = $request->cookie($this->cookie_name);

        if (is_string($cookie_value)) {
            $this->cookie = $this->makeCookie($request->cookie($this->cookie_name));
        }

        $this->browserLanguages = $this->loadBrowserLanguages();
    }

    /**
     * Get config variable.
     *
     * @param string $name
     *
     * @return mixed|void
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->config)) {
            return $this->config[$name];
        }
    }

    /**
     * Set config variable.
     *
     * @param string $name
     *
     * @return void
     */
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->config)) {
            $this->config[$name] = $value;
        }
    }

    /**
     * Get the language cookie.
     *
     * @return null|\Symfony\Component\HttpFoundation\Cookie
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * Get the Request instance.
     *
     * @return \Illuminate\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get current app language.
     *
     * @return string
     */
    public function getLocale()
    {
        return app()->getLocale();
    }

    /**
     * Set app language.
     *
     * @param null|string $locale
     *
     * @return void
     */
    public function setLocale($locale = null)
    {
        $locale = $locale ?? $this->default_locale;

        app()->setLocale($locale);
        $this->cookie = $this->makeCookie($locale);
    }

    /**
     * Check if app language is the same as value of language cookie.
     *
     * @return void
     */
    public function validate()
    {
        if ($this->cookie instanceof Cookie && $this->cookie->getValue() !== $this->getLocale()) {
            $this->setLocale($this->cookie->getValue());
        } elseif (!$this->cookie) {
            $this->setLocale($this->auto ? $this->getPreferedLanguage() : null);
        }
    }

    /**
     * Load browser languages from http header.
     *
     * @return array
     */
    private function loadBrowserLanguages()
    {
        $locales = explode(',', $this->request->header('Accept-Language'));
        $languages = [];
        foreach ($locales as $locale) {
            $data = explode(';', $locale);
            array_push($languages, [
                'locale'     => $data[0],
                'quality'    => (isset($data[1])) ? (float) str_replace('q=', '', $data[1]) : 1.0,
            ]);
        }

        return $languages;
    }

    /**
     * Get prefered language by comparing browser language and app languages.
     *
     * @return string
     */
    public function getPreferedLanguage()
    {
        $locale = reset($this->browserLanguages)['locale'];
        if (strpos($locale, '-') !== false) {
            $codes = explode('-', $locale);
            foreach ($codes as $code) {
                if ($this->langDirExists($code)) {
                    return $code;
                }
            }
        }

        return $this->langDirExists($locale) ? $locale : $this->default_locale;
    }

    /**
     * Get browser languages from http header.
     *
     * @return array
     */
    public function getBrowserLanguages()
    {
        return $this->browserLanguages;
    }

    /**
     * Create a new cookie instance.
     *
     * @param string $value
     *
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function makeCookie($value)
    {
        return cookie()->forever($this->cookie_name, $value);
    }

    /**
     * Check if translation directory for specified language exists.
     *
     * @param string $path
     *
     * @return bool
     */
    private function langDirExists($path)
    {
        $path = strtolower($path);

        return file_exists(app()->langPath().vsprintf('/%s', $path));
    }
}
