<?php

namespace Unit\Kernel\Components\File\Excel\SpreadSheet;

use Codeception\Test\Unit;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\File\Excel\SpreadSheet\BaseXls;
use Kernel\Components\File\Excel\SpreadSheet\ExcelWorker;
use Kernel\Components\File\ReportData;
use Kernel\Components\Response\ResponseFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Unit\Kernel\Components\File\Csv\MockCsvWriter;


class ExcelWorkerTest extends Unit
{
    protected ExcelWorker $worker;

    protected function _before(): void
    {
       ResponseFactory::reset();
       $this->worker = new ExcelWorker(
           new MockExcelWriter(),
           new BaseXls(),
           new ConfigFile(['runtimeFolder' => __DIR__])
       );
    }

    public function testCreate()
    {
        $file = $this->worker->create(new ReportData(items: [['id' => 13, 'name' => 'SOME_NAME']]));
        $this->assertTrue(file_exists($file));
        $data = $this->getDataFromExcelFile($file);
        $this->assertEquals(MockExcelWriter::ADDITIONAL_DATA, $data[0]);
        $this->assertEquals(MockExcelWriter::TITLES, $data[1]);
        $this->assertEquals(['13','SOME_NAME'], $data[2]);
    }

    public function testSend()
    {
        $file = $this->worker->create(new ReportData(items: [['id' => 13, 'name' => 'SOME_NAME']]));
        $this->worker->send($file, 'SEND_FILE_NAME.xls');
        $response = ResponseFactory::getResponse();
        $this->assertEquals('application/vnd.ms-excel; charset=utf-8', $response->getHeader('content-type')[0]);
        $this->assertEquals(
            'attachment; filename="SEND_FILE_NAME.xls"; filename*=UTF-8\'\'SEND_FILE_NAME.xls',
            $response->getHeader('content-disposition')[0]
        );
        $data = $this->getExcelDataFromString($response->getBody()->getContents());
        $this->assertEquals(MockExcelWriter::ADDITIONAL_DATA, $data[0]);
        $this->assertEquals(MockExcelWriter::TITLES, $data[1]);
        $this->assertEquals(['13','SOME_NAME'], $data[2]);
    }

    protected function getDataFromExcelFile(string $file): array
    {
        $reader = IOFactory::createReader(IOFactory::READER_XLS);
        $result = $reader->load($file)->getActiveSheet()->toArray();
        unlink($file);
        return $result;
    }

    protected function getExcelDataFromString(string $resource): array
    {
        $stream = fopen(__DIR__ . '/temp.xls', 'w');
        fwrite($stream, $resource);
        fclose($stream);
        return $this->getDataFromExcelFile(__DIR__ . '/temp.xls');
    }
}
