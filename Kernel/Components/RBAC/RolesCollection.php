<?php

declare(strict_types=1);

namespace Kernel\Components\RBAC;

use Kernel\Enums\EnumCollection;

/**
 * @template-extends EnumCollection<Roles, string>
 */
class RolesCollection extends EnumCollection
{
    public function getEnumName(): string
    {
        return Roles::class;
    }
}
