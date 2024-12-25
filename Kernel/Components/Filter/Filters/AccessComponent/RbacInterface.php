<?php

namespace Kernel\Components\Filter\Filters\AccessComponent;

use Kernel\Components\RBAC\Permissions;

interface RbacInterface
{
    /**
     * @return list<Permissions>
     */
    public function getPermissions(): array;
}
