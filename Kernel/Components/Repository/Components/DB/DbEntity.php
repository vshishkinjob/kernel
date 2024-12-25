<?php

declare(strict_types=1);

namespace Kernel\Components\Repository\Components\DB;

use Cycle\ORM\EntityProxyInterface;
use Cycle\ORM\Mapper\Proxy\EntityProxyTrait;
use Exception;
use Kernel\Components\Exception\App\FunctionNotFoundException;
use Kernel\Components\Exception\App\InvalidReflectionTypeException;
use Kernel\Components\Exception\App\NotValidEntityException;
use Kernel\Components\Exception\App\NullParamException;
use Kernel\Components\Helpers\ObjectTypeCast;
use Kernel\Components\Repository\Components\BaseEntity;
use Kernel\Components\Repository\Components\DB\Orm\RelationMapMock;
use Kernel\Enums\ConvertibleEnumInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;

abstract class DbEntity extends BaseEntity
{
    /**
     * @return array<string, mixed>
     * @throws NotValidEntityException
     * @throws NullParamException
     */
    public function jsonSerialize(): array
    {
        $entity = new ReflectionClass($this);
        if ($this instanceof EntityProxyInterface) {
            $parentClass = $entity->getParentClass();
            if (is_bool($parentClass)) {
                throw new NotValidEntityException();
            }
            /**
             * Объекты сущностей Cycle используют прокси EntityProxyTrait
             * В трэйте есть магический __get, который автоматически подгружает зависимости,
             * что может приводить к зацикливанию и является не нужным поведением
             */
            if (in_array(EntityProxyTrait::class, array_keys($entity->getTraits()), true)) {
                /**
                 * @psalm-suppress UndefinedThisPropertyAssignment
                 */
                $this->__cycle_orm_rel_map = RelationMapMock::getInstance();
            }
        }
        /**
         * @var array<int, ReflectionProperty> $properties
         * @var ReflectionClass<self>|null $parentClass
         */
        $properties = isset($parentClass)
            ? $parentClass->getProperties(ReflectionProperty::IS_PRIVATE)
            : $entity->getProperties(ReflectionProperty::IS_PRIVATE);

        $propertiesArr = [];
        array_walk_recursive($properties, function (ReflectionProperty $property) use (&$propertiesArr): void {
            $value = $property->getValue($this);
            if ($value instanceof ConvertibleEnumInterface) {
                $value = $value->getLabel();
            }
            $propertiesArr[$property->getName()] = $value;
        }, $propertiesArr);
        /**
         * @var array<string, mixed> $propertiesArr
         */
        return $propertiesArr;
    }

    /**
     * dynamically call setter
     * Example: for field "name" it's been setName($value)
     *
     * @param array<string, mixed> $data
     * @return void
     * @throws FunctionNotFoundException
     * @throws ReflectionException|Exception
     */
    public function setData(array $data): void
    {
        foreach ($data as $field => $value) {
            $method = 'set' . $field;
            if (!method_exists($this, $method)) {
                throw new FunctionNotFoundException();
            }
	        $this->{$method}($this->parseValue($value, $method));
        }
    }

	/**
	 * @throws ReflectionException
	 * @throws Exception
	 */
    private function parseValue(mixed $value, string $method): mixed
    {
        if ($value === null) {
            return null;
        }

        $method = (new ReflectionClass($this))->getMethod($method);
        $param = $method->getParameters()[0];

        $type = $param->getType();
        if (!$type instanceof ReflectionNamedType) {
            throw new InvalidReflectionTypeException('Parameters parsing only allowed with ReflectionNamedType');
        }
        $type = $type->getName();

        if ((class_exists($type) || interface_exists($type)) && !$value instanceof $type) {
            return ObjectTypeCast::convertValueToObject($value, $type);
        }
        return $value;
    }
}
