<?php

namespace Kernel\Components\File\Excel\SpreadSheet;

use Kernel\Components\Exception\App\NotInitializedVariableException;
use Kernel\Components\File\FileSaveInterface;
use Kernel\Components\File\WriteInterface;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class BaseXls implements FileSaveInterface
{
    private ?IWriter $writer;

	/**
	 * @throws NotInitializedVariableException
	 * @throws Exception
	 */
    public function save(string $filename): void
    {
        if (!isset($this->writer)) {
            throw new NotInitializedVariableException('Set writer before save');
        }

        $this->writer->save($filename);
    }

    public function setWriter(WriteInterface $writer): void
    {
        $this->writer = new Xls($writer->getWriter());
    }
}
