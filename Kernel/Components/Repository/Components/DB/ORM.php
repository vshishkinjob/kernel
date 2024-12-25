<?php

namespace Kernel\Components\Repository\Components\DB;

/** @template TEntity of DbEntity */

readonly class ORM
{
    /** @param AbstractDbRepository<TEntity> $orm */
    public function __construct(
        protected AbstractDbRepository $orm
    ) {
    }
}
