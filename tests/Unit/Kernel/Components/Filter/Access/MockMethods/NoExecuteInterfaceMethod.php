<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Filter\Access\MockMethods;

use Kernel\Components\Filter\Filters\AccessComponent\RbacInterface;
use Kernel\Components\Method\AbstractDTO;

class NoExecuteInterfaceMethod implements RbacInterface
{
    public function __construct()
    {
    }

    public function execute(AbstractDTO $dto): void
    {
    }

    public function getPermissions(): array
    {
        return [];
    }
}
