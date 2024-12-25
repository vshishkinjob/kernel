<?php

declare(strict_types=1);

namespace Kernel\Enums;

use ArrayIterator;
use BackedEnum;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Kernel\Components\Exception\App\NotValidEntityException;
use Traversable;
use TypeError;
use ValueError;

/**
 * @template TEnum of BackedEnum
 * @template TType of int|string
 * @template-implements IteratorAggregate<int, TEnum>
 */
abstract class EnumCollection implements IteratorAggregate, Countable, JsonSerializable
{
    final public function __construct()
    {
    }

    /** @var list<TEnum> $enums */
    private array $enums = [];

    /**
     * @phan-suppress PhanTypeMismatchProperty
     * @param TEnum $enum
     * @return static
     * @throws NotValidEntityException
     */
    final public function add(BackedEnum $enum): static
    {
        $this->validateEnum($enum);

        if (!$this->inArray($enum)) {
            $this->enums[] = $enum;
        }
        return $this;
    }

    /**
     * @param list<value-of<TEnum>> $enums
     * @return static
     * @throws NotValidEntityException|TypeError|ValueError
     */
    final public function addRawValues(array $enums): static
    {
        $enumName = $this->getEnumName();
        foreach ($enums as $value) {
            /** @var int|string $value */
            $this->add($enumName::from($value));
        }
        return $this;
    }

    public function count(): int
    {
        return count($this->enums);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->enums);
    }

    /** @return list<TType> */
    public function getAllValues(): array
    {
        $result = [];
        foreach ($this->enums as $enum) {
            /** @var TType $value */
            $value = $enum->value;
            $result[] = $value;
        }
        return $result;
    }

    /** @return list<string> */
    public function getAllKeys(): array
    {
        $result = [];
        foreach ($this->enums as $enum) {
            $result[] = $enum->name;
        }
        return $result;
    }

    /**
     * @param TEnum $enum
     * @throws NotValidEntityException
     */
    public function inArray(BackedEnum $enum): bool
    {
        $this->validateEnum($enum);
        return in_array($enum, $this->enums, true);
    }

    /**
     * @param static<TEnum, TType>|null $except
     * @return static
     * @throws NotValidEntityException
     */
    public function createCollectionForAllCases(?self $except = null): static
    {
        if ($except !== null && !$except instanceof $this) {
            throw new NotValidEntityException("Некорректная коллекция!");
        }
        $collection  = new static();
        foreach ($this->getEnumName()::cases() as $enum) {
            if ($except === null || !$except->inArray($enum)) {
                $collection->add($enum);
            }
        }
        return $collection;
    }

    /** @return class-string<TEnum> */
    abstract public function getEnumName(): string;

    /**
     * @throws NotValidEntityException
     */
    private function validateEnum(BackedEnum $enum): void
    {
        $enumName = $this->getEnumName();
        if (!$enum instanceof $enumName) {
            throw new NotValidEntityException("Передан Enum некорректного типа!");
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
