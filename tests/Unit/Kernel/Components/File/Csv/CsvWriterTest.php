<?php

namespace Unit\Kernel\Components\File\Csv;

use Codeception\Test\Unit;
use Kernel\Components\File\ReportData;

class CsvWriterTest extends Unit
{
	public function testWrite()
	{
		$data = $this->make(ReportData::class, ['items' => []]);
		$mock = new MockCsvWriter();
		$mock->write($data);
		$abc = 123;
	}


}