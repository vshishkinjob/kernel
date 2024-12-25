<?php

namespace Kernel\Components\Repository\Components;

use JsonSerializable;
use Kernel\Enums\ConvertibleEnumInterface;
use ReflectionClass;
use ReflectionProperty;

class BaseEntity implements JsonSerializable
{
    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $entity = new ReflectionClass($this);
        $properties = $entity->getProperties(ReflectionProperty::IS_PRIVATE);
        $propertiesArr = [];
        foreach ($properties as $property) {
            $value = $property->getValue($this);
            if ($value instanceof ConvertibleEnumInterface) {
                $value = $value->getLabel();
            }
            $propertiesArr[$property->getName()] = $value;
        }
        return $propertiesArr;
    }

    /**
     * @return array<string, mixed>
     */
    public function asArray(): array
    {
        return $this->jsonSerialize();
    }
}
