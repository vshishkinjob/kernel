<?php

namespace Kernel\Enums;

trait ConvertableEnumTrait
{
    public function getLabel(): string
    {
        return $this->getLabels()[$this->value] ?? 'Undefined';
    }
}
