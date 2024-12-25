<?php

declare(strict_types=1);

namespace Kernel\Components\Google\Spreadsheet;

final readonly class SpreadsheetConfig
{
    public function __construct(
        public string $authCredentialsPath,
        public string $spreadsheetId,
        public string $spreadsheetName
    ) {
    }
}
