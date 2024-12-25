<?php

declare(strict_types=1);

namespace Kernel\Components\File\Excel\ExcelBook;

use ExcelBook;
use ExcelFormat;
use InvalidArgumentException;
use Kernel\Components\Exception\App\EmptyDataException;
use Kernel\Components\File\Excel\ExcelBook\config\ExcelConfigurator;
use Kernel\Components\Response\ResponseFactory;
use Slim\Psr7\Stream;
use SplFileInfo;

abstract class BaseXlsReport implements BaseReport
{
    protected readonly ExcelBook $spreadsheet;

    public function __construct(
        private readonly ExcelConfigurator $configurator
    ) {
        $this->spreadsheet = new ExcelBook();
        $this->spreadsheet->setLocale($this->configurator->locale);
        $this->loadTemplate();
    }

    /**
     * @throws InvalidArgumentException
     * @throws EmptyDataException
     */
    public function export(): void
    {
        $this->write(data: $this->prepareData());
        $this->save();
    }

    /**
     * @param array{0: list<array<string, mixed>>, 1:array<string, string>} $data
     * @throws EmptyDataException
     */
    public function write(array $data): void
    {
        $sheet = $this->spreadsheet->getSheet();

        for ($id = 0, $last = $sheet->lastRow(); $id < $last; $id++) {
            /** @var array<int, null|string> $row */
            $row = $sheet->readRow($id);
            $skippedRows = $this->fill($row, $data, $id);

            is_null($skippedRows)
                ? $sheet->writeRow($id, $row)
                : $id += $skippedRows;
        }
    }

    abstract public function templatePath(): string;

    abstract public function filename(): string;

    /**
     * @return array{0: list<array<string, mixed>>, 1:array<string, string>}
     */
    protected function prepareData(): array
    {
        return [
            $this->tableData(),
            $this->additionalData()
        ];
    }

    /**
     * Необходимо переопределить, если шаблон содержит значения с паттерном %key%, которые не равны %table%.
     * Ключи массива должны совпадать с ключом паттерна.
     * @return array<string, string>
     */
    protected function additionalData(): array
    {
        return [];
    }

    /**
     * Необходимо переопределить, если шаблон содержит динамически сгенерированную таблицу с шаблоном %table%.
     * Этот метод должен возвращать массив табличных данных.
     * @return list<array<string, mixed>>
     */
    protected function tableData(): array
    {
        return [];
    }

    /**
     * Необходимо переопределить, если шаблон содержит динамически сгенерированную таблицу с паттерном %table%.
     * Этот метод объявляет поля, которые будут использоваться для заполнения динамической таблицы данных.
     * Порядок столбцов таблицы должен быть объявлен путем сортировки значений массива.
     * @return list<string>
     */
    protected function tableFields(): array
    {
        return [];
    }

    /**
     * @throws InvalidArgumentException
     */
    private function save(): void
    {
        $this->spreadsheet->save($this->configurator->tempFilePath);
        $this->setHeaders();
        $this->unlinkTempFile();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function setHeaders(): void
    {
        $response = ResponseFactory::getResponse();
        $encodedFilename = rawurlencode($this->filename());
        $response = $response->withHeader('Access-Control-Expose-Headers', 'Content-Disposition, Content-Type')
            ->withHeader('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
            ->withHeader(
                'Content-Disposition',
                "attachment; filename=\"{$this->filename()}\"; filename*=UTF-8''$encodedFilename"
            );
        $resource = fopen($this->configurator->tempFilePath, 'r');
        if ($resource !== false) {
            $stream = new Stream($resource);
            ResponseFactory::setResponse($response->withBody($stream));
        }
    }

    /**
     * @phan-suppress PhanPartialTypeMismatchArgument
     * @param array<int, null|string> $row
     * @param array{0: list<array<string, mixed>>, 1:array<string, string>} $data
     * @throws EmptyDataException
     */
    private function fill(array &$row, array $data, int $id): int|null
    {
        list($table, $additional) = $data;

        foreach ($row as $index => $cell) {
            if ($cell && preg_match_all($this->configurator->pattern, $cell, $matches)) {
                /** @var array{0: list<string>, 1: list<string>} $matches */
                if ($this->isTable($matches)) {
                    return $this->fillTable($table, $id);
                }
                $this->fillValue($matches, $additional, $row, $index);
            }
        }

        return null;
    }

    /**
     * @param array{0: list<string>, 1: list<string>} $matches
     * @param array<string, string> $additional
     * @param array<int, null|string> $row
     * @throws EmptyDataException
     */
    private function fillValue(array $matches, array $additional, array &$row, int $cell): void
    {
        foreach (array_keys($matches[0]) as $key) {
            if (!isset($additional[$matches[1][$key]])) {
                throw new EmptyDataException();
            }
            $row[$cell] = str_replace($matches[0][$key], $additional[$matches[1][$key]], $row[$cell] ?? '');
        }
    }

    /**
     * @param list<array<string, mixed>> $data
     */
    private function fillTable(array $data, int $currentRow): int
    {
        if (empty($data)) {
            //Стираем %table% из строки
            $this->spreadsheet->getSheet()->writeRow($currentRow, [''], 0, $this->stylizeRow());
            return 0;
        }

        foreach ($data as $key => $value) {
            $row = array_map(function (string $field) use ($value) {
                return $value[$field] ?? '';
            }, $this->tableFields());

            $this->spreadsheet->getSheet()->writeRow($currentRow + $key, $row, 0, $this->stylizeRow());
            $this->spreadsheet->getSheet()->setRowHeight($currentRow + $key, $this->rowHeight());
        }
        return count($data);
    }

    /**
     * @param array{0: list<string>, 1: list<string>} $matches
     */
    private function isTable(array $matches): bool
    {
        return $matches[0][0] == $this->configurator->tablePattern;
    }

    private function loadTemplate(): void
    {
        $path = $this->templatePath();
        if (file_exists($path) && $this->extensionIsValid($path)) {
            $this->spreadsheet->loadFile($path);
        }
    }

    private function extensionIsValid(string $filename): bool
    {
        return in_array(
            (new SplFileInfo($filename))->getExtension(),
            ['xls', 'xlsx'],
            true
        );
    }

    private function stylizeRow(): ExcelFormat
    {
        $format = $this->spreadsheet->addFormat();
        $format->borderStyle(ExcelFormat::BORDERSTYLE_THIN);
        $format->borderColor(ExcelFormat::COLOR_OCEANBLUE_CF);
        $format->horizontalAlign(ExcelFormat::ALIGNH_CENTER);
        $format->verticalAlign(ExcelFormat::ALIGNV_JUSTIFY);

        return $format;
    }

    protected function rowHeight(): int
    {
        return $this->configurator->baseRowHeight;
    }

    protected function unlinkTempFile(): void
    {
        unlink($this->configurator->tempFilePath);
    }
}
