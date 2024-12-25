<?php

namespace Unit\Kernel\Components\Repository\Db;

use Codeception\Test\Unit;
use Cycle\Database\Exception\StatementException\ConnectionException;
use Cycle\ORM\Select\ScopeInterface;
use Kernel\Components\Exception\DB\Exceptions\ConnectionException as ConnectionExceptionKernel;
use Kernel\Components\Logger\KernelLoggerInterface;
use Kernel\Components\Repository\Components\DB\Orm\Select;
use Throwable;

class SelectTest extends Unit
{
    public function testCatchCallThrow()
    {
        $this->expectException(ConnectionExceptionKernel::class);
        $select = new Select(
            $this->makeEmpty(\Cycle\ORM\Select::class, [
                'scope' => function (ScopeInterface $scope) {
                    throw new ConnectionException($this->makeEmpty(Throwable::class), 'query');
                }
            ]),
            $this->makeEmpty(KernelLoggerInterface::class)
        );
        $select->scope($this->makeEmpty(ScopeInterface::class));
    }
}