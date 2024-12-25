<?php

namespace Unit\Kernel\Components\File\UploadFile;

use Codeception\Test\Unit;
use Kernel\Components\File\UploadFile\PsrUploadedFile;
use Psr\Http\Message\UploadedFileInterface as PsrUploadedFileInterface;

class PsrUploadedFileTest extends Unit
{
	public function testValidPsrUploadedFile()
	{
		$psrMock = $this->makeEmpty(PsrUploadedFileInterface::class,[
			'getSize' => 1000,
			'getClientFilename' => 'FILE_NAME'
		]);
		$file = new PsrUploadedFile($psrMock);
		$this->assertEquals(1000, $file->getFileSize());
		$this->assertEquals("FILE_NAME", $file->getFileName());
	}

	public function testEmptyFileSize()
	{
		$psrMock = $this->makeEmpty(PsrUploadedFileInterface::class,[
			'getSize' => null,
		]);
		$file = new PsrUploadedFile($psrMock);
		$this->assertFalse($file->getFileSize());
	}
}