<?php

declare(strict_types=1);

namespace Kernel\Components\Request\Validators\Rest;

enum HttpMethod: string
{
    case POST = 'POST';
	case OPTIONS = 'OPTIONS';

    /** @return list<value-of<self::*>> */
    public static function getValuesAsArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
