<?php

namespace mputkowski\Tests\Locale;

use GrahamCampbell\TestBenchCore\FacadeTrait;
use mputkowski\Locale\Facades\Locale as LocaleFacade;
use mputkowski\Locale\Locale;

class FacadeTest extends AbstractTestCase
{
    use FacadeTrait;

    protected function getFacadeAccessor()
    {
        return 'locale';
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
