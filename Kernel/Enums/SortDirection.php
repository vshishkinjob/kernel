<?php

namespace Kernel\Enums;

enum SortDirection: string
{
    case ASC = 'ASC';
    case DESC = 'DESC';

    /**
     * @return list<value-of<self::*>>
     */
    public static function getValuesAsArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
