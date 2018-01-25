<?php

namespace mputkowski\Locale\Facades;

use Illuminate\Support\Facades\Facade;

class Locale extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Locale';
    }
}
