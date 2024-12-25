<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Repository\Db\TypeCast;

use Codeception\Test\Unit;
use Kernel\Components\Repository\Components\DB\TypeCast\EmailTypeCast;
use Kernel\Components\Repository\Components\DB\TypeCast\UrlTypeCast;
use Kernel\ValueObjects\Email;
use Kernel\ValueObjects\Url;
use Unit\Tools\PropertyHelper;

class UrlTypeCastTest extends Unit
{
    public function testCastSuccess()
    {
        $typeCast = new UrlTypeCast();
        $array = [
            'column1' => UrlTypeCast::class
        ];
        $typeCast->setRules($array);
        $data = [
            'column1' => 'https://google.com',
        ];
        $result = $typeCast->cast($data);
        $this->assertEquals([
            'column1' => new Url('https://google.com')
        ], $result);
    }

    public function testUncastSuccess()
    {
        $typeCast = new UrlTypeCast();
        $array = [
            'column1' => UrlTypeCast::class
        ];
        $typeCast->setRules($array);
        $data = [
            'column1' => new Url('https://google.com')
        ];
        $result = $typeCast->uncast($data);
        $this->assertEquals([
            'column1' => 'https://google.com'
        ], $result);
    }
}
