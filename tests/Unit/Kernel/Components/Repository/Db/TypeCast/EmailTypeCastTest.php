<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Repository\Db\TypeCast;

use Codeception\Test\Unit;
use Kernel\Components\Repository\Components\DB\TypeCast\EmailTypeCast;
use Kernel\Components\Repository\Components\DB\TypeCast\UrlTypeCast;
use Kernel\ValueObjects\Email;
use Unit\Tools\PropertyHelper;

class EmailTypeCastTest extends Unit
{
    public function testCastSuccess()
    {
        $typeCast = new EmailTypeCast();
        $array = [
            'column2' => EmailTypeCast::class,
            'column4' => EmailTypeCast::class
        ];
        $typeCast->setRules($array);
        $data = [
            'column2' => 'test@test.com',
            'column4' => 'test2@test.com'
        ];
        $result = $typeCast->cast($data);
        $this->assertEquals([
            'column2' => new Email('test@test.com'),
            'column4' => new Email('test2@test.com')
        ], $result);
    }

    public function testUncastSuccess()
    {
        $typeCast = new EmailTypeCast();
        $array = [
            'column2' => EmailTypeCast::class,
            'column4' => EmailTypeCast::class
        ];
        $typeCast->setRules($array);
        $data = [
            'column2' => new Email('test@test.com'),
            'column4' => new Email('test2@test.com')
        ];
        $result = $typeCast->uncast($data);
        $this->assertEquals([
            'column2' => 'test@test.com',
            'column4' => 'test2@test.com'
        ], $result);
    }
}
