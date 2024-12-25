<?php

declare(strict_types=1);

namespace Kernel\Components\Repository\Components\Tps\Annotation;

use Kernel\Components\Exception\App\TypeCastException;
use Kernel\Components\Helpers\ObjectTypeCast;

class TypeCast implements TypeCastInterface
{
    /**
     * @var list<string>
     */
    private static array $primitiveTypes = [
        'int',
        'float',
        'array',
        'bool',
    ];

    /**
     * @param array<array-key,mixed>|bool|float|int|string|null $value
     * @param non-empty-string $type
     * @return mixed
     * @throws \Exception|TypeCastException
     */
    public static function cast(int|array|string|float|bool|null $value, string $type): mixed
    {
        if (is_null($value)) {
            return null;
        }

        if (self::isPrimitive($type)) {
            /** @var int|mixed[]|string|float|bool $value */
            return self::castPrimitive($value, $type);
        }

        if (class_exists($type) || interface_exists($type)) {
            return ObjectTypeCast::convertValueToObject($value, $type);
        }

        return $value;
    }

    /**
     * @param non-empty-string $type
     */
    private static function isPrimitive(string $type): bool
    {
        return in_array($type, self::$primitiveTypes, true);
    }

    /**
     * @param int|mixed[]|string|float|bool $value
     * @param non-empty-string $type
     * @return int|mixed[]|float|bool
     * @throws \Exception|TypeCastException
     */
    private static function castPrimitive(int|array|string|float|bool $value, string $type): int|array|float|bool
    {
        return match ($type) {
            'int' => self::castPrimitiveToInt($value),
            'float' => self::castPrimitiveToFloat($value),
            'array' => (array)$value,
            'bool' => (bool) $value,
            default => throw new TypeCastException()
        };
    }

    /**
     * @param int|mixed[]|string|float|bool $value
     * @throws TypeCastException
     */
    private static function castPrimitiveToFloat(int|array|string|float|bool $value): float
    {
        if (is_array($value) || !is_numeric($value)) {
            throw new TypeCastException();
        }
        return (float)$value;
    }

    /**
     * @param int|mixed[]|string|float|bool $value
     * @throws TypeCastException
     */
    private static function castPrimitiveToInt(int|array|string|float|bool $value): int
    {
        if (is_array($value) || !is_numeric($value)) {
            throw new TypeCastException();
        }
        return (int)$value;
    }
}
