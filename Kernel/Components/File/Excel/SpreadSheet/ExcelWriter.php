<?php

namespace Kernel\Components\File\Excel\SpreadSheet;

use Kernel\Components\File\ReportData;
use Kernel\Components\File\WriteInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

abstract class ExcelWriter implements WriteInterface
{
    protected int $startRow = 1;
    protected Spreadsheet $spreadsheet;
    protected ReportData $data;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
    }

    public function write(ReportData $data): void
    {
        $this->setData($data);
        $this->setStyles();
        $this->setTitles();
        $this->setBody();
    }

    public function setStartRow(int $index): void
    {
        $this->startRow = $index;
    }

    public function getWriter(): Spreadsheet
    {
        return $this->spreadsheet;
    }

    protected function setTitles(): void
    {
        $titles = $this->getTitles();

        foreach ($titles as $index => $title) {
            $this->spreadsheet->getActiveSheet()->setCellValue([$index + 1, $this->startRow], $title);
        }
    }

    protected function setBody(): void
    {
        $tableData = $this->formatTableDataForXls();

        foreach ($tableData as $index => $data) {
            $index += $this->startRow + 1;
            $this->renderRow($data, $index);
        }

        $this->setAdditionalData();
    }

    /**
     * @param array<string, float|int|string|null> $data
     */
    protected function renderRow(array $data, int $rowIndex): void
    {
        foreach (array_values($data) as $index => $value) {
            $this->spreadsheet->getActiveSheet()->setCellValue([$index + 1, $rowIndex], $value);
        }
    }

    protected function setStyles(): void
    {
        foreach ($this->getStyles() as $index => $style) {
            $this->spreadsheet->getActiveSheet()->getStyle($index)->applyFromArray($style);
        }

        $this->setAdditionalStyles();
    }

    protected function setData(ReportData $data): void
    {
        $this->data = $data;
    }

    protected function setAdditionalData(): void
    {
        //overwrite if you need some additional data
    }

    /**
     * @return array<string, mixed>
     */
    protected function getAdditionalData(): array
    {
        return [];
    }

    protected function setAdditionalStyles(): void
    {
        //overwrite if you need some additional style
    }

    /**
     * @return list<string>
     */
    abstract protected function getTitles(): array;

    /**
     * @return array<string,mixed[]>
     */
    abstract protected function getStyles(): array;

    /**
     * @return list<array<string, float|int|string|null>>
     */
    abstract protected function formatTableDataForXls(): array;
}
