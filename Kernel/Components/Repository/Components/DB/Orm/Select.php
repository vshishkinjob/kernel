<?php

namespace Kernel\Components\Repository\Components\DB\Orm;

use Cycle\Database\Query\SelectQuery;
use Cycle\ORM\Select as SelectCycle;
use Cycle\ORM\Select\QueryBuilder;
use Kernel\Components\Exception\DB\BaseDbException;
use Kernel\Components\Exception\DB\DbExceptionResolver;
use Kernel\Components\Logger\KernelLoggerInterface;

/**
 * @method $this distinct()
 * @method $this where(...$args)
 * @method $this andWhere(...$args);
 * @method $this orWhere(...$args);
 * @method $this having(...$args);
 * @method $this andHaving(...$args);
 * @method $this orHaving(...$args);
 * @method $this orderBy($expression, $direction = 'ASC');
 * @method $this forUpdate()
 * @method $this whereJson(string $path, mixed $value)
 * @method $this orWhereJson(string $path, mixed $value)
 * @method $this whereJsonContains(string $path, mixed $value, bool $encode = true, bool $validate = true)
 * @method $this orWhereJsonContains(string $path, mixed $value, bool $encode = true, bool $validate = true)
 * @method $this whereJsonDoesntContain(string $path, mixed $value, bool $encode = true, bool $validate = true)
 * @method $this orWhereJsonDoesntContain(string $path, mixed $value, bool $encode = true, bool $validate = true)
 * @method $this whereJsonContainsKey(string $path)
 * @method $this orWhereJsonContainsKey(string $path)
 * @method $this whereJsonDoesntContainKey(string $path)
 * @method $this orWhereJsonDoesntContainKey(string $path)
 * @method $this whereJsonLength(string $path, int $length, string $operator = '=')
 * @method $this orWhereJsonLength(string $path, int $length, string $operator = '=')
 * @method mixed avg($identifier) Perform aggregation (AVG) based on column or expression value.
 * @method mixed min($identifier) Perform aggregation (MIN) based on column or expression value.
 * @method mixed max($identifier) Perform aggregation (MAX) based on column or expression value.
 * @method mixed sum($identifier) Perform aggregation (SUM) based on column or expression value.
 * @method $this wherePK(string|int|array|object $id)
 * @method $this load(string|array $relation, array $options = [])
 * @method $this with(string|array $relation, array $options = [])
 * @method TEntity|null fetchOne(array|null $query = null)
 * @method array<int, TEntity> fetchAll()
 * @method array<int, array> fetchData(bool $typecast = true)
 * @method $this limit(int $limit)
 * @method $this offset(int $offset)
 * @method int count()
 * @method QueryBuilder getBuilder()
 * @method SelectQuery buildQuery()
 *
 * @template TEntity of object
 */
final readonly class Select
{
    public function __construct(
        /** @var SelectCycle<TEntity> $select */
        private SelectCycle $select,
        private KernelLoggerInterface $logger
    ) {
    }

    /**
     * @phan-suppress PhanPluginAlwaysReturnMethod
     * @param mixed[] $arguments
     * @throws BaseDbException
     */
    public function __call(string $name, array $arguments): mixed
    {
        try {
            if (method_exists($this->select, $name)) {
                $result = $this->select->$name(...$arguments);
            } else {
                $result = $this->select->__call($name, $arguments);
            }
            if ($result instanceof SelectCycle) {
                return $this;
            }
            return $result;
        } catch (\Throwable $exception) {
            DbExceptionResolver::resolveDbException($exception, $this->logger);
        }
    }
}
