<?php

namespace Kernel\Enums\User;

enum SubjectStatus: int
{
    case ACTIVE = 1;
    case BLOCKED_BY_USER = 2;
    case BLOCKED_BY_SYSTEM = 3;
    case SUSPICIOUS = 4;
    case DELETING = 5;
    case CLOSED = 6;
    case BLOCKED_BY_PARTNER = 7;
    case CREATED = 11;
    case MODERATING = 12;

    /** @return list<value-of<self::*>> */
    public static function getValuesAsArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
