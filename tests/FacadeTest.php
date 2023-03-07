<?php

namespace mputkowski\Tests\Localization;

use GrahamCampbell\TestBenchCore\FacadeTrait;
use mputkowski\Localization\Facades\Localization as LocalizationFacade;
use mputkowski\Localization\Localization;

class FacadeTest extends AbstractTestCase
{
    use FacadeTrait;

    protected static function getFacadeAccessor(): string
    {
        return 'Localization';
    }

    protected static function getFacadeClass(): string
    {
        return LocalizationFacade::class;
    }

    protected static function getFacadeRoot(): string
    {
        return Localization::class;
    }
}
