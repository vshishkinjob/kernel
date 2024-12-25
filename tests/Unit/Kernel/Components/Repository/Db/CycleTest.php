<?php

namespace Unit\Kernel\Components\Repository\Db;

use Codeception\Test\Unit;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\DB\DbException;
use Kernel\Components\Exception\DB\Exceptions\ConnectionException;
use Kernel\Components\Logger\KernelLoggerInterface;
use Kernel\Components\Repository\Components\DB\Orm\Cycle;
use Kernel\Definitions\DbConfig;
use Psr\SimpleCache\CacheInterface;

class CycleTest extends Unit
{
    public function testCreateDbEntitySuccessfully()
    {
        $config = new ConfigFile([
            'db' => [
                'dbName' => 'wooppay',
                'host' => 'dbweb',
                'port' => 5432,
                'user' => 'cabinet',
                'password' => 'zBeTb04Ql192ji',
                'availableSchemas' => ['woopdb', 'core']
            ],
            'dbEntitiesFolder' => __DIR__
        ]);

        $dbConfig = new DbConfig($config);

        $cycle = new Cycle(
            $dbConfig,
            $this->makeEmpty(KernelLoggerInterface::class),
            $config,
            $this->makeEmpty(CacheInterface::class, [
                'has' => false
            ])
        );

        $dbal = $cycle->getDbal();
    }

    public function testGetDbNameFails()
    {
        $this->expectException(DbException::class);
        $config = new ConfigFile([
            'db' => [
                'dbName' => 'wooppay',
                'host' => 'dbweb',
                'port' => 5432,
                'user' => 'cabinet',
                'password' => 'zBeTb04Ql192ji',
                'availableSchemas' => ['woopdb', 'core']
            ],
            'dbEntitiesFolder' => __DIR__
        ]);

        $dbConfig = new DbConfig($config);

        $cycle = new Cycle(
            $dbConfig,
            $this->makeEmpty(KernelLoggerInterface::class),
            $config,
            $this->makeEmpty(CacheInterface::class, [
                'has' => false
            ])
        );

        $cycle->getDb('SOME_NOT_EXIST_DB_NAME');
    }

    public function testCreateDbEntityFails()
    {
        $this->expectException(ConnectionException::class);
        $config = new ConfigFile([
            'db' => [
                'dbName' => 'wooppay',
                'host' => 'dbweb',
                'port' => 5432,
                'user' => 'SOM_USER',
                'password' => 'SOME_PASSWORD',
                'availableSchemas' => ['woopdb', 'core']
            ],
            'dbEntitiesFolder' => __DIR__
        ]);

        $dbConfig = new DbConfig($config);

        new Cycle(
            $dbConfig,
            $this->makeEmpty(KernelLoggerInterface::class),
            $config,
            $this->makeEmpty(CacheInterface::class, [
                'has' => false
            ])
        );
    }
}