<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Filter\Access\MockMethods;

use Kernel\Components\Method\AbstractDTO;
use Kernel\Components\Method\ExecuteInterface;
use Kernel\Components\Method\NullDTO;
use Kernel\Components\RBAC\Permissions;

class NoRbacMethod implements ExecuteInterface
{
    public function __construct()
    {
    }

    public function execute(AbstractDTO $dto): bool
    {
        return true;
    }

    public function getMethodDto(): NullDTO
    {
        return new NullDTO();
    }

    public function getPermissions(): array
    {
        return [Permissions::ACCESS_PARTNER_CABINET];
    }
}
