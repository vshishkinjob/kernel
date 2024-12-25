<?php

namespace Kernel\ValueObjects;

/**
 * @template-extends ValueObjectCollection<Url, string>
 */
final class UrlCollection extends ValueObjectCollection
{
    public function getValueObjectName(): string
    {
        return Url::class;
    }
}
