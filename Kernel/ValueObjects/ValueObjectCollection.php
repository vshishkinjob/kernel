<?php

declare(strict_types=1);

namespace Kernel\ValueObjects;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Kernel\Components\Exception\App\NotValidEntityException;
use Kernel\Components\Exception\Validation\ValidationException;
use Traversable;
use TypeError;

/**
 * @template TValueObject of AbstractValueObject
 * @template TType
 * @template-implements IteratorAggregate<int, TValueObject>
 */
abstract class ValueObjectCollection implements IteratorAggregate, Countable, JsonSerializable
{
    final public function __construct()
    {
    }

    /** @var  list<TValueObject> $valueObjects */
    private array $valueObjects = [];

    /**
     * @psalm-suppress InvalidPropertyAssignmentValue
     * @phan-suppress PhanTypeMismatchProperty
     * @param TValueObject $valueObject
     * @return static
     * @throws NotValidEntityException
     */
    final public function add(AbstractValueObject $valueObject): static
    {
        $this->validateObject($valueObject);

        $new = clone $this;
        $new->valueObjects[] = $valueObject;
        return $new;
    }

    /**
     * @param list<TType> $values
     * @return static
     * @throws NotValidEntityException|TypeError|ValidationException
     */
    final public function addRawValues(array $values): static
    {
        $newCollection = $this;
        $valueObjectName = $this->getValueObjectName();
        foreach ($values as $value) {
            /** @var TType $value */
            $newCollection = $newCollection->add(new $valueObjectName($value));
        }
        return $newCollection;
    }

    public function count(): int
    {
        return count($this->valueObjects);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->valueObjects);
    }

    /** @return list<TType> */
    public function getAllValues(): array
    {
        $result = [];
        foreach ($this->valueObjects as $valueObject) {
            $result[] = $valueObject->getValue();
        }
        return $result;
    }

    /**
     * @return list<TType>
     */
    public function getUniqueValues(): array
    {
        $result = [];
        foreach ($this->valueObjects as $valueObject) {
            if (!in_array($valueObject->getValue(), $result, strict: true)) {
                $result[] = $valueObject->getValue();
            }
        }
        return $result;
    }

    /**
     * @param TValueObject $valueObject
     * @throws NotValidEntityException
     * @psalm-suppress MixedMethodCall
     */
    public function inArray(AbstractValueObject $valueObject): bool
    {
        $this->validateObject($valueObject);

        foreach ($this->valueObjects as $object) {
            if ($object->getValue() === $valueObject->getValue()) {
                return true;
            }
        }
        return false;
    }

    /** @return class-string<TValueObject> */
    abstract public function getValueObjectName(): string;

    /**
     * @param AbstractValueObject<TType> $valueObject
     * @throws NotValidEntityException
     */
    private function validateObject(AbstractValueObject $valueObject): void
    {
        $valueObjectName = $this->getValueObjectName();
        if (!$valueObject instanceof $valueObjectName) {
            throw new NotValidEntityException("Передан ValueObject некорректного типа!");
        }
    }

    /**
     * @return list<TType>
     */
    public function jsonSerialize(): array
    {
        return $this->getAllValues();
    }
}
