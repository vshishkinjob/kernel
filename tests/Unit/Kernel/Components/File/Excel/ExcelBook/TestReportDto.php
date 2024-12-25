<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\File\Excel\ExcelBook;

readonly class TestReportDto
{
	public function __construct(
        /**@var list<array{id: int, data:string}>*/
		private array $items,
	) {}

    /**
     * @return list<array{id: int, data:string}>
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
