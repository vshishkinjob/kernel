<?php

declare(strict_types=1);

namespace Kernel\Enums\User;

use Kernel\Enums\EnumCollection;

/**
 * @template-extends EnumCollection<SubjectStatus, int>
 */
class SubjectStatusCollection extends EnumCollection
{
    public function getEnumName(): string
    {
        return SubjectStatus::class;
    }
}
