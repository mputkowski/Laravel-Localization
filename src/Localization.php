<?php

namespace mputkowski\Localization;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
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
     * Create a new Localization instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Illuminate\Http\Request                $request
     *
     * @return void
     */
    public function __construct(Config $config, Request $request)
    {
        if (!$config->has('localization')) {
            throw new FileNotFoundException('Missing localization config');
        }
        
        $this->config = $config;
        $this->request = $request;

        $cookie_name = $this->config->get('localization.cookie_name');
        $cookie_value = $request->cookie($cookie_name);

        if (is_string($cookie_value)) {
            $this->cookie = $this->makeCookie($request->cookie($cookie_name));
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
        $locale = $locale ?? $this->config->get('localization.default_locale');

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
            $this->setLocale($this->config->get('localization.auto') ? $this->getPreferredLanguage() : null);
        }
    }

    /**
     * Get preferred language by comparing browser language and app languages.
     *
     * @return string
     */
    public function getPreferredLanguage()
    {
        $locales = $this->getAvailableLocales();
        return $this->request->getPreferredLanguage($locales);
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
        return cookie()->forever($this->config->get('localization.cookie_name'), $value);
    }

    /**
     * Get available locales
     *
     * @return array
     */
    private function getAvailableLocales()
    {
        return array_diff(scandir(app()->langPath()), array('..', '.'));
    }
}
