<?php

namespace Kernel\Components\Repository\Components\DB;

use Kernel\Components\Logger\KernelLoggerInterface;
use Kernel\Components\Repository\Components\DB\Interfaces\Entity\CreateInterface;
use Kernel\Components\Repository\Components\DB\Interfaces\Entity\DeleteInterface;
use Kernel\Components\Repository\Components\DB\Interfaces\Entity\ReadInterface;
use Kernel\Components\Repository\Components\DB\Interfaces\Entity\UpdateInterface;
use Kernel\Components\Repository\Components\DB\Interfaces\Repository\RepositoryInterface;
use Kernel\Definitions\interfaces\DbConfigInterface;

/**
 * @template TEntity of DbEntity
 * @template-implements ReadInterface<TEntity>
 * @template-implements CreateInterface<TEntity>
 */
abstract class AbstractDbRepository implements CreateInterface, DeleteInterface, ReadInterface, UpdateInterface
{
    public function __construct(
        protected readonly DbConfigInterface $dbConfig,
        protected readonly KernelLoggerInterface $logger
    ) {
    }

    /** @return RepositoryInterface<TEntity> */
    abstract public function repository(DbInterface $repository): RepositoryInterface;
}
