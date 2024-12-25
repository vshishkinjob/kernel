<?php

namespace Unit\Kernel\Components\File;

use Codeception\Test\Unit;
use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\File\ViewRenderer;


class ViewRendererTest extends Unit
{
    private ViewRenderer $renderer;

    public function _before()
    {
        $this->renderer = new ViewRenderer();
    }

    public function testNotExistingView()
    {
        $filePath = '/some/not_exist/file.php';

        $this->expectException(FileNotFoundException::class);
        $this->expectExceptionMessage("File: $filePath was not found");

        $this->renderer->renderView($filePath);
    }

    public function testExistingView()
    {
        $filePath = __DIR__ . '/test.php';

        $result = $this->renderer->renderView($filePath, ['message' => 'MESSAGE']);

        $this->assertEquals('<div> Message: MESSAGE</div>', $result);
    }
}
