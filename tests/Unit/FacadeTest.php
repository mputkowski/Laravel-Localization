<?php
namespace mputkowski\Tests\Locale\Unit;

use mputkowski\Locale\Locale;
use mputkowski\Locale\Facades\Locale as LocaleFacade;
use GrahamCampbell\TestBenchCore\FacadeTrait;

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
