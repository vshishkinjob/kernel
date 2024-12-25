<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Repository\Db\TypeCast;

use Codeception\Test\Unit;
use Kernel\Components\Repository\Components\DB\TypeCast\JsonTypeCast;

class JsonTypeCastTest extends Unit
{
    public function testCastSuccess()
    {
        $typeCast = new JsonTypeCast();
        $array = [
            'column1' => JsonTypeCast::class,
            'column2' => JsonTypeCast::class,
            'column3' => JsonTypeCast::class
        ];
        $typeCast->setRules($array);
        $data = [
            'column1' => json_encode([
                'test' => 'result'
            ]),
            'column2' => null,
            'column3' => 123123
        ];
        $result = $typeCast->cast($data);
        $this->assertEquals([
            'column1' => [
                'test' => 'result'
            ],
            'column2' => null,
            'column3' => null
        ], $result);
    }

    public function testUncastSuccess()
    {
        $typeCast = new JsonTypeCast();
        $array = [
            'column1' => JsonTypeCast::class,
            'column2' => JsonTypeCast::class
        ];
        $typeCast->setRules($array);
        $data = [
            'column1' => [
                'test' => 'result'
            ],
            'column2' => null
        ];
        $result = $typeCast->uncast($data);
        $this->assertEquals([
            'column1' => json_encode([
                'test' => 'result'
            ]),
            'column2' => null
        ], $result);
    }
}
