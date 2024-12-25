<?php

namespace Unit\Tools;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class PropertyHelper
{
    /**
     * Получение приватного поля по текущему классу и всем родителям
     * @throws ReflectionException
     */
    public static function getPropertyRecursive(object $class, string $property, ?string $currentClass = null): mixed
    {
        try {
            $reflectionProperty = new ReflectionProperty($currentClass ?? $class::class, $property);
            return $reflectionProperty->getValue($class);
        } catch (ReflectionException $exception) {
            $reflection = new ReflectionClass($currentClass ?? $class);
            if ($parent = $reflection->getParentClass()){
                return self::getPropertyRecursive($class, $property, $parent->getName());
            }
        }

        throw new ReflectionException("Unable to find property: $property recursively in class: " . $class::class);
    }

    /**
     * @throws ReflectionException
     */
    public static function getParentProperty(object $class, string $property): mixed
    {
        $reflection = new ReflectionClass($class);
        $parent = $reflection->getParentClass();

        return $parent->getProperty($property)->getValue($class);
    }

    /**
     * @throws ReflectionException
     */
    public static function getProperty(object $class, string $property)
    {
        $reflectionProperty = new ReflectionProperty($class::class, $property);

        return $reflectionProperty->getValue($class);
    }
}