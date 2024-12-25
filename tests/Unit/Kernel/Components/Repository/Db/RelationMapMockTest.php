<?php

namespace Unit\Kernel\Components\Repository\Db;

use Codeception\Test\Unit;
use Kernel\Components\Exception\App\NullParamException;
use Kernel\Components\Repository\Components\DB\Orm\RelationMapMock;

class RelationMapMockTest extends Unit
{
    protected function _before()
    {
        RelationMapMock::reset();
    }

    public function testGetInstanceWithoutInitialization()
    {
        $this->expectException(NullParamException::class);
        RelationMapMock::getInstance();
    }
}