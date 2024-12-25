<?php

namespace Kernel\Components\File;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

interface WriteInterface
{
    public function write(ReportData $data): void;

    public function getWriter(): Spreadsheet;
}
