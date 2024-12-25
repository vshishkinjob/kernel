<?php

namespace Unit\Kernel\Components\File;

use Codeception\Test\Unit;
use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\Exception\File\FilePermissionDeniedException;
use Kernel\Components\Exception\File\IncorrectFileFormatException;
use Kernel\Components\Exception\File\UndefinedMimeTypeException;
use Kernel\Components\Exception\Validation\Base64ValidationException;
use Kernel\Components\File\FileHelper;
use Kernel\Components\File\UploadFile\SplUploadedFile;

class FileHelperTest extends Unit
{
	private FileHelper $fileHelper;

	public function _before()
	{
		$this->fileHelper = new FileHelper();
	}

	public function testFailWhenIsNotBase64Input(): void
	{
		$this->expectException(Base64ValidationException::class);

		$this->fileHelper->getFileObjectFromBase64('THIS_NOT_BASE64_ENCODED_STRING');
	}

	public function testFailWhenFileNotExistToCopy(): void
	{
		$from = '/not_exist.txt';

		$this->expectException(FileNotFoundException::class);
		$this->expectExceptionMessage("File $from do not exists");

		$this->fileHelper->copyFile($from, './some.txt');
		unlink('./some.txt');
	}

	public function testSuccessConvertingFile(): void
	{
		$file = $this->fileHelper->getFileObjectFromBase64($this->getFile());
		$this->assertRegExp("#/tmp/php.*\.png#", $file->getFileFullPath());
		$this->assertInstanceOf(SplUploadedFile::class, $file);
		$this->assertEquals('png', $file->getExtension());
		$this->assertEquals(19951, $file->getSize());
	}

	private function getFile(): string
	{
		return file_get_contents(__DIR__ . '/image.txt');
	}

	public function testGetExtensionFromPath()
	{
		$extension = $this->fileHelper->getExtensionFromPath(__DIR__ . '/image.txt', true);
		$this->assertEquals('txt', $extension);
	}

	public function testGetExtensionFromFileWithoutExtension()
	{
		$this->expectException(IncorrectFileFormatException::class);
		$this->fileHelper->getExtensionFromPath(__DIR__ . '/without_extension', true);
	}

	public function testIncorrectMimeTypeFile()
	{
		$this->expectException(IncorrectFileFormatException::class);
		$this->fileHelper->getExtensionFromPath(__DIR__ . '/image.png', true);
	}

	public function testCopyFile()
	{
		$from = realpath(__DIR__ . '/image.txt');
		$to = realpath('runtime') . '/image.txt';
		$result = $this->fileHelper->copyFile($from, $to);
		$this->assertEquals($to, $result->getPathname());
		unlink($to);
	}

	public function testCopyFunctionFailed()
	{
		$this->expectException(FilePermissionDeniedException::class);
		mkdir("./test", 0000);
		$from = realpath(__DIR__ . '/image.txt');
		$to = realpath('runtime') . '/test/image.txt';
		$this->fileHelper->copyFile($from, $to);
		unlink('./test');
	}

	//Todo пока не понятно как сделать темпфолдер не доступной для записи
	public function testTempFileCreationFailed()
	{
//		$this->expectException(FilePermissionDeniedException::class);
//		chmod(__DIR__ . "/test", 0777);
//		putenv("TMPDIR=" . realpath(__DIR__ . "/test"));
//		$x = sys_get_temp_dir();
//		$this->fileHelper->getFileObjectFromBase64($this->getFile());
//		unlink(__DIR__ . "/test");
//		putenv("TMPDIR=" . realpath("/tmp"));
	}

	public function testWrongMime()
	{
		$this->expectException(UndefinedMimeTypeException::class);
		$this->fileHelper->getExtensionFromPath('wrong file path', true);
	}

	public function testWrongBase64()
	{
		$this->expectException(Base64ValidationException::class);
		$this->fileHelper->getFileObjectFromBase64('not base 64');
	}
}
