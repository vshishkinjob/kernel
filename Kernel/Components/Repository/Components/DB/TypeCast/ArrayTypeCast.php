<?php

declare(strict_types=1);

namespace Kernel\Components\Repository\Components\DB\TypeCast;

use Kernel\Components\Exception\App\TypeCastException;

class ArrayTypeCast extends AbstractDbTypeCast
{
    /**
     * @param mixed $data
     * @return list<int|float|string>|null
     */
    protected function convertToApplicationFormat(mixed $data): ?array
    {
        if (!is_string($data) || !preg_match('/^{.*}$/', $data)) {
            return null;
        }

        $result = explode(',', trim($data, '{}'));
        foreach ($result as $key => $value) {
            $result[$key] = is_numeric($value)
                ? (str_contains($value, '.') ? (float)$value : (int)$value)
                : $value;
        }
        return $result;
    }

    /**
     * @throws TypeCastException
     */
    protected function convertToDbFormat(mixed $data): string
    {
        if (!is_iterable($data)) {
            throw new TypeCastException('Unable to convert not array to array db format!');
        }

        $result = [];
        foreach ($data as $value) {
            if (!is_scalar($value)) {
                throw new TypeCastException("Not supported type! Only scalar is supported!");
            }
            $result[] = $value;
        }
        return '{' . trim(implode(',', $result), ',') . '}';
    }
}
