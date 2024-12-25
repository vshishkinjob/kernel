<?php

namespace Kernel\Components\File\Csv;

use Kernel\Components\File\ReportData;
use Kernel\Components\File\WriteInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

abstract class CsvWriter implements WriteInterface
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

    private function setTitles(): void
    {
        $titles = $this->getTitles();

        foreach ($titles as $index => $title) {
            $this->spreadsheet->getActiveSheet()->setCellValue([$index + 1, $this->startRow], $title);
        }
    }

    private function setBody(): void
    {
        $tableData = $this->formatTableDataForCsv();

        foreach ($tableData as $index => $data) {
            $index += $this->startRow + 1;
            $this->renderRow($data, $index);
        }

        $this->setAdditionalData();
    }

    /**
     * @param array<string, float|int|string|null> $data
     */
    private function renderRow(array $data, int $rowIndex): void
    {
        foreach (array_values($data) as $index => $value) {
            $this->spreadsheet->getActiveSheet()->setCellValue([$index + 1, $rowIndex], $value);
        }
    }

    private function setStyles(): void
    {
        foreach ($this->getStyles() as $index => $style) {
            $this->spreadsheet->getActiveSheet()->getStyle($index)->applyFromArray($style);
        }

        $this->setAdditionalStyles();
    }

    private function setData(ReportData $data): void
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
    abstract protected function formatTableDataForCsv(): array;
}
