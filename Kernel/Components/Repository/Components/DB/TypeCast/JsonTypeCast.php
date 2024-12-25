<?php

declare(strict_types=1);

namespace Kernel\Components\Repository\Components\DB\TypeCast;

use Kernel\Components\Exception\App\TypeCastException;

class JsonTypeCast extends AbstractDbTypeCast
{
    protected function convertToApplicationFormat(mixed $data): mixed
    {
        if (!is_string($data)) {
            return null;
        }
        return json_decode($data, true);
    }

    /**
     * @throws TypeCastException
     */
    protected function convertToDbFormat(mixed $data): string
    {
        $result = json_encode($data);

        return $result !== false ? $result : throw new TypeCastException('Unable to convert data to json type!');
    }
}
