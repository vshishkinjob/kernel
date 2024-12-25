<?php

namespace Unit\Kernel\Components\File\Csv;

use Codeception\Test\Unit;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\Exception\File\FilePermissionDeniedException;
use Kernel\Components\File\Csv\BaseCsv;
use Kernel\Components\File\Csv\CsvWorker;
use Kernel\Components\File\ReportData;
use Kernel\Components\Response\ResponseFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;


class CsvWorkerTest extends Unit
{
	protected CsvWorker $worker;

	protected function _before(): void
	{
		ResponseFactory::reset();
		$this->worker = new CsvWorker(
			new MockCsvWriter(),
			new BaseCsv(),
			new ConfigFile(['runtimeFolder' => __DIR__])
		);
	}

	public function testCreate()
	{
		$file = $this->worker->create(new ReportData(items: [['id' => 13, 'name' => 'SOME_NAME']]));
		$this->assertTrue(file_exists($file));
		$data = $this->getDataFromCsvFile($file);
		$this->assertEquals(MockCsvWriter::ADDITIONAL_DATA, $data[0]);
		$this->assertEquals(MockCsvWriter::TITLES, $data[1]);
		$this->assertEquals(['13', 'SOME_NAME'], $data[2]);

	}

	public function testCorrectFileCreationPath()
	{
		$path = $this->worker->create(new ReportData(items: [['id' => 13, 'name' => 'SOME_NAME']]));
		$this->assertRegExp("#^" . realpath(__DIR__) . "\/[0-9a-z]{13}\.csv$#", $path);
		unlink($path);
	}

	public function testUnableAccessFile()
	{
		$file = $this->worker->create(new ReportData(items: [['id' => 13, 'name' => 'SOME_NAME']]));
		chmod($file, 222);
		try {
			$this->worker->send($file, 'SEND_FILE_NAME.csv');
		} catch (\Throwable $exception) {
			$this->assertInstanceOf(FilePermissionDeniedException::class, $exception);
		}
		unlink($file);
	}

	public function testSend()
	{
		$file = $this->worker->create(new ReportData(items: [['id' => 13, 'name' => 'SOME_NAME']]));
		$this->worker->send($file, 'SEND_FILE_NAME.csv');
		$response = ResponseFactory::getResponse();
		$this->assertEquals('application/csv; charset=utf-8', $response->getHeader('content-type')[0]);
		$this->assertEquals(
			'attachment; filename="SEND_FILE_NAME.csv"; filename*=UTF-8\'\'SEND_FILE_NAME.csv',
			$response->getHeader('content-disposition')[0]
		);
		$data = $this->getCsvDataFromString($response->getBody()->getContents());
		$this->assertEquals(MockCsvWriter::ADDITIONAL_DATA, $data[0]);
		$this->assertEquals(MockCsvWriter::TITLES, $data[1]);
		$this->assertEquals(['13', 'SOME_NAME'], $data[2]);
		$this->assertFalse(file_exists($file));
	}

	protected function getDataFromCsvFile(string $file): array
	{
		$reader = IOFactory::createReader(IOFactory::READER_CSV);
		$result = $reader->load($file)->getActiveSheet()->toArray();
		unlink($file);
		return $result;
	}

	protected function getCsvDataFromString(string $resource): array
	{
		$stream = fopen(__DIR__ . '/temp.csv', 'w');
		fwrite($stream, $resource);
		fclose($stream);
		return $this->getDataFromCsvFile(__DIR__ . '/temp.csv');
	}
}
