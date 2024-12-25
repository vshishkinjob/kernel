<?php

namespace Kernel\Components\Repository\Components\Tps\Annotation;

interface TypeCastInterface
{
    /**
     * @param int|mixed[]|string|float|bool|null $value
     * @param non-empty-string $type
     * @return mixed
     * @throws \Exception
     */
    public static function cast(int|array|string|float|bool|null $value, string $type): mixed;
}
