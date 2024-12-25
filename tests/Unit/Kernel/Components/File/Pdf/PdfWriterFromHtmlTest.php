<?php

namespace Unit\Kernel\Components\File\Pdf;

use Codeception\Test\Unit;
use Kernel\Components\File\Pdf\PdfWriterFromHtml;

class PdfWriterFromHtmlTest extends Unit
{
    private PdfWriterFromHtml $writer;

    protected function _before(): void
    {
        $this->writer = new PdfWriterFromHtml();
    }

    public function testCreatingPdfFile()
    {
        $file = $this->writer->generatePdfFromHtml(
            html: '<div>Test PDF</div>',
            title: 'File_Name',
            dest: 'F'
        );

        $this->assertStringContainsString('File_Name', $file);
        $this->assertFileExists($file);

        unlink($file);
    }
}
