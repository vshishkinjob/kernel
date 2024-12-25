<?php

namespace Kernel\Components\File\Csv;

use Kernel\Components\Exception\App\NotInitializedVariableException;
use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\File\FileSaveInterface;
use Kernel\Components\File\WriteInterface;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;
use PhpOffice\PhpSpreadsheet\Writer\Exception;

class BaseCsv implements FileSaveInterface
{
	private ?IWriter $writer;

	/**
	 * @throws Exception
	 * @throws NotInitializedVariableException
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
		$this->writer = new Csv($writer->getWriter());
	}
}
