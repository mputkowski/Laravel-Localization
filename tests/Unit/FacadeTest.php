<?php

namespace mputkowski\Tests\Locale\Unit;

use GrahamCampbell\TestBenchCore\FacadeTrait;
use mputkowski\Locale\Facades\Locale as LocaleFacade;
use mputkowski\Locale\Locale;

class FacadeTest extends AbstractTestCase
{
    use FacadeTrait;

    protected function getFacadeAccessor()
    {
        return 'Locale';
    }

    protected function getFacadeClass()
    {
        return LocaleFacade::class;
    }

    protected function getFacadeRoot()
    {
        return Locale::class;
    }
}
