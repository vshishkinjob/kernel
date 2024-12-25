<?php

namespace Kernel\Components\Repository\Components\Tps\Annotation;

use Attribute;

#[Attribute]
final class TpsColumn
{
    /**
     * @param string|list<string> $name - field name from tps
     * @param string|null $type - type to convert
     *
     * Example:
     * #TpsColumn(name: 'test_tps_field', type: DateTime::class)
     * #TpsColumn(name: 'test_tps_name', type: SomeNameEnum::class)
     */
    public function __construct(
        private string|array $name,
        private ?string $type = null
    ) {
    }

    /** @return string|list<string> */
    public function getName(): string|array
    {
        return $this->name;
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}
