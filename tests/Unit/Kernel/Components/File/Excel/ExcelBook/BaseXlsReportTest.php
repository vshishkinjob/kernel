<?php

namespace Unit\Kernel\Components\File\Excel\ExcelBook;

use Codeception\Attribute\Skip;
use Codeception\Test\Unit;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\App\EmptyDataException;
use Kernel\Components\File\Excel\ExcelBook\config\ExcelConfigurator;
use Kernel\Components\Response\ResponseFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BaseXlsReportTest extends Unit
{
    protected function _before(): void
    {
        ResponseFactory::reset();
    }

    /*public function testSuccessfulReportXlsCreation()
    {
        $dataDto = new TestReportDto(
            [
                [
                    'id' => 12,
                    'data' => 'SOME_DATA'
                ],
                [
                    'id' => 13,
                    'data' => "ANOTHER_DATA"
                ]
            ]
        );
        $config = new ExcelConfigurator(new ConfigFile(['runtimeFolder' => __DIR__]));
        $report = $this->construct(
            TestXlsReport::class,
            [
                'data' => $dataDto,
                'excelConfigurator' => $config,
            ],
            [
                'unlinkTempFile' => function () {},
            ]
        );
        $report->export();
        $response = ResponseFactory::getResponse();
        $this->assertNotEmpty($response->getHeader('content-disposition')[0]);
        $this->assertEquals('application/vnd.ms-excel; charset=utf-8', $response->getHeader('content-type')[0]);

        $dataFromFile = $this->getDataFromFile();
        $this->assertEquals('SOME_ADDITIONAL_DATA', $dataFromFile[1][0]);
        $this->assertEquals("12", $dataFromFile[4][1]);
        $this->assertEquals("SOME_DATA", $dataFromFile[4][2]);
        $this->assertEquals("13", $dataFromFile[5][1]);
        $this->assertEquals("ANOTHER_DATA", $dataFromFile[5][2]);
    }

    public function testFailWithoutDataIfItDefinedInTemplate()
    {
        $dataDto = new TestReportDto(
            [
                [
                    'id' => 12,
                    'data' => 'SOME_DATA'
                ]
            ]
        );
        $config = new ExcelConfigurator(new ConfigFile(['runtimeFolder' => __DIR__]));
        $report = $this->construct(
            FailXlsReport::class,
            [
                'data' => $dataDto,
                'excelConfigurator' => $config,
            ],
            [
                'unlinkTempFile' => function () {}
            ]
        );
        $this->expectException(EmptyDataException::class);
        $report->export();
    }*/

    private function getDataFromFile(): array
    {
        $reader = IOFactory::createReader(IOFactory::READER_XLS);
        $result = $reader->load(__DIR__ . '/temp.xls')->getActiveSheet()->toArray();
        unlink(__DIR__ . '/temp.xls');
        return $result;
    }
}
