<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Repository\Db\TypeCast;

use Codeception\Test\Unit;
use Kernel\Components\Repository\Components\DB\TypeCast\ArrayTypeCast;

class ArrayTypeCastTest extends Unit
{
    public function testCastSuccess()
    {
        $typeCast = new ArrayTypeCast();
        $array = [
            'column1' => ArrayTypeCast::class,
            'column2' => ArrayTypeCast::class,
            'column3' => ArrayTypeCast::class,
            'column4' => ArrayTypeCast::class
        ];
        $typeCast->setRules($array);
        $data = [
            'column1' => '{1,2.3,5}',
            'column2' => null,
            'column3' => 123123,
            'column4' => 'asdasd'
        ];
        $result = $typeCast->cast($data);
        $this->assertEquals([
            'column1' => [
               1,2.3,5
            ],
            'column2' => null,
            'column3' => null,
            'column4' => null
        ], $result);
    }

    public function testUncastSuccess()
    {
        $typeCast = new ArrayTypeCast();
        $array = [
            'column1' => ArrayTypeCast::class,
            'column2' => ArrayTypeCast::class
        ];
        $typeCast->setRules($array);
        $data = [
            'column1' => [
                1,2.5,5
            ],
            'column2' => null
        ];
        $result = $typeCast->uncast($data);
        $this->assertEquals([
            'column1' => '{1,2.5,5}',
            'column2' => null
        ], $result);
    }
}
