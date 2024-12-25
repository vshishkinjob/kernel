<?php

namespace Kernel\ValueObjects;

/**
 * @template-extends AbstractValueObject<string>
 */
final readonly class AppUniqueId extends AbstractValueObject
{
    private string $uniqueId;

    public function __construct(mixed $value = null)
    {
        parent::__construct($value);
        $this->uniqueId = uniqid('', true);
    }

    public function getValue(): string
    {
        return $this->uniqueId;
    }

    protected function validate(mixed $value): void
    {
    }
}
