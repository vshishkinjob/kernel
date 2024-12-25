<?php

namespace Kernel\Components\Google\Spreadsheet;

use Google\Service\Sheets;
use Google\Service\Sheets\Resource\SpreadsheetsValues;
use Google\Service\Sheets\ValueRange;
use Kernel\Components\Config\ConfigFile;
use Throwable;

final readonly class GoogleSpreadsheet
{
    public function __construct(
        private Sheets $googleService,
        private string $spreadsheetId,
        private string $spreadsheetName
    ) {
    }

    /**
     * @param array<string, string> $params
     * @throws GoogleException
     */
    public function append(ValueRange $values, array $params = []): void
    {
        try {
            /** @var SpreadsheetsValues $spreadsheet */
            $spreadsheet = $this->googleService->spreadsheets_values;

            $spreadsheet->append(
                $this->spreadsheetId,
                $this->spreadsheetName,
                $values,
                $params
            );
        } catch (Throwable $exception) {
            throw new GoogleException($exception);
        }
    }
}
