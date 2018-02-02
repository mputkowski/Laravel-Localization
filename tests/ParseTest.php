<?php

use mputkowski\Locale\Locale;
use PHPUnit\Framework\TestCase;

class ParseTest extends TestCase
{
    protected $locale;

    public function setUp()
    {
        $config = [
            'auto'           => true,
            'cookie_name'    => 'lang',
            'default_locale' => 'en',
            'routes'         => false,
        ];

        $this->locale = new Locale($config);
    }

    public function testParseHttpHeader()
    {
        $header = 'en,en-US;q=0.9,de;q=0.8,pl;q=0.7';
        $arr1 = $this->locale->getBrowserLanguages($header);
        $arr2 = [
            ['lang' => 'en', 'q' => 1.0],
            ['lang' => 'en-US', 'q' => 0.9],
            ['lang' => 'de', 'q' => 0.8],
            ['lang' => 'pl', 'q' => 0.7], ];

        $this->assertEquals($arr1, $arr2);
    }
}
