<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\Repository;

use Kernel\Enums\ConvertableEnumTrait;
use Kernel\Enums\ConvertibleEnumInterface;

enum ConvertableEnumMock: int implements ConvertibleEnumInterface
{
    use ConvertableEnumTrait;

    case TEST = 13;
    case TEST2 = 14;

    public static function getLabels(): array
    {
        return [
            self::TEST->value => 'CONVERTED_VALUE',
            self::TEST2->value => 'ANOTHER_CONVERTED_VALUE'
        ];
    }
}
