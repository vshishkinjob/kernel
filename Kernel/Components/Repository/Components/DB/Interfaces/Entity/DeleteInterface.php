<?php

namespace Kernel\Components\Repository\Components\DB\Interfaces\Entity;

use Kernel\Components\Repository\Components\DB\DbEntity;

interface DeleteInterface
{
    public function delete(DbEntity $entity, bool $cascade = true): void;
}
