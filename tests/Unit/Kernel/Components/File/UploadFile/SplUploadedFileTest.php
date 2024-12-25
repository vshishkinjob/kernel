<?php

namespace Unit\Kernel\Components\File\UploadFile;

use Codeception\Test\Unit;
use Kernel\Components\File\UploadFile\SplUploadedFile;

class SplUploadedFileTest extends Unit
{
	public function testCheckTempFileDeleted()
	{
		file_put_contents(__DIR__ . "/test.txt", "r");
	    $file = new SplUploadedFile(__DIR__ . '/test.txt');
		unset($file);
		$this->assertFalse(file_exists(__DIR__ . '/test.txt'));
	}
}