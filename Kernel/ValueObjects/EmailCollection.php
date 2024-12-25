<?php

namespace Kernel\ValueObjects;

/**
 * @template-extends ValueObjectCollection<Email, string>
 */
final class EmailCollection extends ValueObjectCollection
{
    public function getValueObjectName(): string
    {
        return Email::class;
    }
}
