<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Helpers;

use Codeception\Test\Unit;
use Kernel\Components\Helpers\Transliterator;

class TransliteratorTest extends Unit
{
    public function testTransliterateWithCapital()
    {
        $string = ' это_Некая_сТрока ';
        $this->assertEquals('eto_Nekaya_sTroka',Transliterator::transliterate($string, keepCapital: true));
    }

    public function testTransliterateWithoutCapital()
    {
        $string = ' это_Некая_сТрока ';
        $this->assertEquals('eto_nekaya_stroka',Transliterator::transliterate($string));
    }
}