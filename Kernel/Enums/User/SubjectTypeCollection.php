<?php

declare(strict_types=1);

namespace Kernel\Enums\User;

use Kernel\Enums\EnumCollection;

/**
 * @template-extends EnumCollection<SubjectType, int>
 */
class SubjectTypeCollection extends EnumCollection
{
    public function getEnumName(): string
    {
        return SubjectType::class;
    }
}
