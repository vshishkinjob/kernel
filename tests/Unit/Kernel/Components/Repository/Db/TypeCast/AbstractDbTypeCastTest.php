<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Repository\Db\TypeCast;

use Codeception\Test\Unit;
use Kernel\Components\Repository\Components\DB\TypeCast\EmailTypeCast;
use Kernel\Components\Repository\Components\DB\TypeCast\UrlTypeCast;
use Unit\Tools\PropertyHelper;

class AbstractDbTypeCastTest extends Unit
{
    public function testRules()
    {
        $typeCast = new EmailTypeCast();
        $array = [
            'column1' => UrlTypeCast::class,
            'column2' => EmailTypeCast::class,
            'column3' => 'string',
            'column4' => EmailTypeCast::class
        ];
        $rules = $typeCast->setRules($array);
        $this->assertEquals([
            'column1' => UrlTypeCast::class,
            'column3' => 'string'
        ], $rules);
        $columns = PropertyHelper::getPropertyRecursive($typeCast, 'columns');
        $this->assertEquals(['column2', 'column4'], $columns);
    }
}
