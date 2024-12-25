<?php

declare(strict_types=1);

namespace Kernel\ValueObjects;

use JsonSerializable;
use Kernel\Components\Exception\Validation\ValidationException;

/**
 * @phpstan-consistent-constructor
 * @psalm-consistent-constructor
 * @template TType
 */
abstract readonly class AbstractValueObject implements JsonSerializable
{
    /**
     * @throws ValidationException
     */
    public function __construct(mixed $value)
    {
        $this->validate($value);
    }

    /**
     * @throws ValidationException
     */
    abstract protected function validate(mixed $value): void;

    /**
     * @return TType
     */
    abstract public function getValue(): mixed;

    /**
     * @throws ValidationException
     */
    final public function setValue(mixed $value = null): static
    {
        return new static($value);
    }

    public function jsonSerialize(): mixed
    {
        return $this->getValue();
    }
}
