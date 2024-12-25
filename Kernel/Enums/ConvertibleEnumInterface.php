<?php

namespace Kernel\Enums;

interface ConvertibleEnumInterface
{
    public static function getLabels(): array;

    public function getLabel(): string;
}
