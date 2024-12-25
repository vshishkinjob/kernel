<?php

namespace Kernel\Components\Repository\Components\DB\Interfaces\Entity;

use Kernel\Components\Exception\DB\DbException;
use Kernel\Components\Repository\Components\DB\DbEntity;

/**
 * @template TEntityCreate of DbEntity
 */
interface CreateInterface
{
    /**
     * @param TEntityCreate $entity
     * @return TEntityCreate
     * @throws DbException
     */
    public function create(DbEntity $entity): DbEntity;
}
