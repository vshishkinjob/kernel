<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\File\Excel\SpreadSheet;

use Kernel\Components\File\Excel\SpreadSheet\ExcelWriter;

class MockExcelWriter extends ExcelWriter
{
    public const ADDITIONAL_DATA = ['additional', 'data'];
    public const TITLES = ['id', 'name'];

    protected int $startRow = 2;

    protected function getTitles(): array
    {
        return self::TITLES;
    }

    protected function getStyles(): array
    {
        return [];
    }

    protected function setAdditionalData(): void
    {
        $additional = $this->getAdditionalData();
        foreach ($additional as $key => $item) {
            $this->spreadsheet->getActiveSheet()->setCellValue([$key + 1, $this->startRow - 1], $item);
        }
    }

    protected function getAdditionalData(): array
    {
        return self::ADDITIONAL_DATA;
    }

    protected function formatTableDataForXls(): array
    {
        $items = $this->data->getItems();
        $result = [];
        foreach ($items as $key => $item) {
            $result[$key][] = $item['id'];
            $result[$key][] = $item['name'];
        }
        return $result;
    }
}