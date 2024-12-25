<?php

namespace Kernel\Components\Repository\Components\DB\Interfaces\Entity;

use Kernel\Components\Exception\Exception;
use Kernel\Components\Repository\Components\DB\DbEntity;
use Kernel\Components\Repository\Components\DB\DbInterface;

/**
 * @template TEntityRead of DbEntity
 */
interface ReadInterface
{
    /**
     * @param array<array-key, mixed> $filters
     * @param array<array-key, mixed> $orderBy
     * @return array<int, TEntityRead>
     * @throws Exception
     */
    public function findAll(DbInterface $repository, array $filters = [], array $orderBy = []): array;

    /**
     * @return TEntityRead
     * @throws Exception
     */
    public function findByPk(DbInterface $repository, int $id): DbEntity;

    /**
     * @param array<array-key, mixed> $filters
     * @return TEntityRead
     * @throws Exception
     */
    public function findOne(DbInterface $repository, array $filters = []): DbEntity;
}
