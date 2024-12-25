<?php

namespace Kernel\Components\Repository\Components\DB;

interface DbInterface
{
    /**
     * @return class-string<DbEntity>
     */
    public function getEntityClassName(): string;
}
