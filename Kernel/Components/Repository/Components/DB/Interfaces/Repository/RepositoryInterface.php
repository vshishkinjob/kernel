<?php

namespace Kernel\Components\Repository\Components\DB\Interfaces\Repository;

use Kernel\Components\Repository\Components\DB\DbEntity;
use Kernel\Components\Repository\Components\DB\Orm\Select;

/**
 * @template TEntity of DbEntity
 */
interface RepositoryInterface
{
    /**
     * @param string|int|list<string|int>|object $id
     * @return TEntity|null
     */
    public function findByPk(string|int|array|object $id): ?DbEntity;

    /**
     * @param array<array-key, mixed> $scope
     * @return TEntity|null
     */
    public function findOne(array $scope = []): ?DbEntity;

    /**
     * @param array<array-key, mixed> $scope
     * @param array<array-key, mixed> $orderBy
     * @return array<int, TEntity>
     */
    public function findAll(array $scope = [], array $orderBy = []): array;

    /** @return Select<TEntity> */
    public function select(): Select;

    /**
     * Метод для получения сырых данных в массиве без typecasting и создания объектов
	 * @param Select<TEntity> $query
     * @return array<array-key, mixed>
     */
    public function getRawData(Select $query): array;
}
