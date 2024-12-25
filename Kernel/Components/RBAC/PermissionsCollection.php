<?php

declare(strict_types=1);

namespace Kernel\Components\RBAC;

use Kernel\Enums\EnumCollection;

/**
 * @template-extends EnumCollection<Permissions, string>
 */
class PermissionsCollection extends EnumCollection
{
    public function getEnumName(): string
    {
        return Permissions::class;
    }
}
