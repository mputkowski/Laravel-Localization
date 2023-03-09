<?php

namespace mputkowski\Tests\Localization;

use GrahamCampbell\TestBenchCore\FacadeTrait;
use mputkowski\Localization\Facades\Localization as LocalizationFacade;
use mputkowski\Localization\Localization;

class FacadeTest extends AbstractTestCase
{
    use FacadeTrait;

    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Localization';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected static function getFacadeClass(): string
    {
        return LocalizationFacade::class;
    }

    /**
     * Get the facade root.
     *
     * @return string
     */
    protected static function getFacadeRoot(): string
    {
        return Localization::class;
    }
}
