<?php

namespace mputkowski\Tests\Localization;

use GrahamCampbell\TestBenchCore\FacadeTrait;
use mputkowski\Localization\Facades\Localization as LocalizationFacade;
use mputkowski\Localization\Localization;

class FacadeTest extends AbstractTestCase
{
    use FacadeTrait;

    protected function getFacadeAccessor()
    {
        return 'Localization';
    }

    protected function getFacadeClass()
    {
        return LocalizationFacade::class;
    }

    protected function getFacadeRoot()
    {
        return Localization::class;
    }
}
