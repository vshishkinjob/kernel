<?php

declare(strict_types=1);

namespace Kernel\Components\File;

class ReportData
{
    public function __construct(
        /** @var array<int, array<string, mixed>> $items */
        private readonly array $items = []
    ) {
    }

    /** @return array<int, array<string, mixed>> */
    public function getItems(): array
    {
        return $this->items;
    }
}
