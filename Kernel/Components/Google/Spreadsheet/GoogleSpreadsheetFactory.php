<?php

declare(strict_types=1);

namespace Kernel\Components\Google\Spreadsheet;

use Google\Service\Sheets;

final class GoogleSpreadsheetFactory
{
    public function create(
        SpreadsheetConfig $config
    ): GoogleSpreadsheet {
        return new GoogleSpreadsheet(
            googleService: $this->createSheets($config->authCredentialsPath),
            spreadsheetId: $config->spreadsheetId,
            spreadsheetName: $config->spreadsheetName
        );
    }

    private function createSheets(string $authCredentialsPath): Sheets
    {
        return new Sheets(
            clientOrConfig: new GoogleClient($authCredentialsPath)
        );
    }
}
