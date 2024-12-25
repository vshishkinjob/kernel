<?php

declare(strict_types=1);

namespace Kernel\Components\Repository\Components\DB\Orm;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\RelationMap;
use Kernel\Components\Exception\App\NullParamException;
use Kernel\Components\Repository\Components\DB\MockEntity\MockDbEntity;

/**
 * Синглтон для создания RelationMap без зависимостей
 * Используется для предотвращения автозагрузки зависимостей через __get в EntityProxyTrait при json_encode сущности
 */
final class RelationMapMock
{
    private static ?RelationMap $relationMap = null;

    private function __construct()
    {
    }

	/**
	 * @throws NullParamException
	 */
    public static function getInstance(?ORMInterface $orm = null): RelationMap
    {
        if (self::$relationMap === null) {
            if ($orm === null) {
                throw new NullParamException();
            }
            self::$relationMap = self::createInstance($orm);
        }
        return self::$relationMap;
    }

    private static function createInstance(ORMInterface $orm): RelationMap
    {
        /**
         * @psalm-suppress InternalClass
         * @psalm-suppress InternalMethod
         */
        return RelationMap::build($orm, MockDbEntity::SCHEME_NAME);
    }

    public static function reset(): void
    {
        self::$relationMap = null;
    }
}
