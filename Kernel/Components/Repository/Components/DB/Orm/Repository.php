<?php

namespace Kernel\Components\Repository\Components\DB\Orm;

use Cycle\ORM\ORM;
use Cycle\ORM\Select as SelectCycle;
use Kernel\Components\Exception\DB\BaseDbException;
use Kernel\Components\Logger\KernelLoggerInterface;
use Kernel\Components\Repository\Components\DB\DbEntity;
use Kernel\Components\Repository\Components\DB\DbInterface;
use Kernel\Components\Repository\Components\DB\Interfaces\Repository\RepositoryInterface;

/**
 * @template TEntity of DbEntity
 * @implements RepositoryInterface<TEntity>
 */
class Repository implements RepositoryInterface
{
    /** @var Select<TEntity> $select */
    protected Select $select;

    public function __construct(ORM $orm, DbInterface $repository, KernelLoggerInterface $logger)
    {
        /** @var SelectCycle<TEntity> $cycleSelect */
        $cycleSelect = new SelectCycle($orm, $repository->getEntityClassName());
        /** @var Select<TEntity> $select */
        $select = new Select($cycleSelect, $logger);
        $this->select = $select;
    }

    public function __clone()
    {
        $this->select = clone $this->select;
    }

    /**
     * @throws BaseDbException
     */
    public function findByPk(string|int|array|object $id): ?DbEntity
    {
        return $this->select()->wherePK($id)->fetchOne();
    }

    /**
     * @throws BaseDbException
     */
    public function findOne(array $scope = []): ?DbEntity
    {
        return $this->select()->fetchOne($scope);
    }

    /**
     * @throws BaseDbException
     */
    public function findAll(array $scope = [], array $orderBy = []): array
    {
        return $this->select()->where($scope)->orderBy($orderBy)->fetchAll();
    }

    /** @return Select<TEntity> */
    public function select(): Select
    {
        return clone $this->select;
    }


    /**
     * @param Select<TEntity> $query
     * @throws BaseDbException
     */
    public function getRawData(Select $query): array
    {
        return $query->fetchData(false);
    }
}
