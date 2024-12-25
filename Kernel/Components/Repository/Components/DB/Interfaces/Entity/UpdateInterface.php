<?php

namespace Kernel\Components\Repository\Components\DB\Interfaces\Entity;

use Kernel\Components\Repository\Components\DB\DbEntity;

interface UpdateInterface
{
    public function update(DbEntity $entity): void;
}
