<?php

namespace Unit\Kernel\Components\Static;

use Codeception\Test\Unit;
use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\Static\StaticFile;
use Kernel\ValueObjects\Url;

class StaticFileTest extends Unit
{
    public function testFailIfUrlDoNotContainsStaticUrl()
    {
        $fullUrl = new Url("https://not-static.com/dir/file.txt");
        $staticPath = '/var/www';
        $staticUrl = "https://static.com";
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Ссылка на файл не содержит url статик сервера!");
        StaticFile::createFromUrl($fullUrl, $staticPath, $staticUrl);
    }

    public function testFailIfUrlDoNotContainValidUrlPath()
    {
        $fullUrl = new Url("https://static.com");
        $staticPath = '/var/www';
        $staticUrl = "https://static.com";
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Не удалось преобразовать url в путь к файлу!");
        $x = StaticFile::createFromUrl($fullUrl, $staticPath, $staticUrl);
    }

    public function testStaticFileCreatedSuccessfullyFromUrl()
    {
        $dir = 'dir/another/';
        $file = 'file.txt';
        $staticPath = '/var/www/';
        $staticUrl = "https://static.com/";
        $fullUrl = new Url($staticUrl . $dir . $file);
        $staticFile = StaticFile::createFromUrl($fullUrl, $staticPath, $staticUrl);
        $this->assertEquals($fullUrl, $staticFile->getStaticFullUrl());
        $this->assertEquals($staticPath . $dir . $file, $staticFile->getStaticFullPath());
        $this->assertEquals($staticPath . $dir, $staticFile->getStaticDirectoryPath());
        $this->assertEquals($file, $staticFile->getStaticFileName());
    }

    public function testGetLocalFullFilePathFailForNotLocalFile()
    {
        $this->expectException(FileNotFoundException::class);
        $dir = 'dir/another/';
        $file = 'file.txt';
        $staticPath = '/var/www/';
        $staticUrl = "https://static.com/";
        $fullUrl = new Url($staticUrl . $dir . $file);
        $staticFile = StaticFile::createFromUrl($fullUrl, $staticPath, $staticUrl);
        $staticFile->getLocalFullFilePath();
    }

    public function testGetLocalFileNameFailForNotLocalFile()
    {
        $this->expectException(FileNotFoundException::class);
        $dir = 'dir/another/';
        $file = 'file.txt';
        $staticPath = '/var/www/';
        $staticUrl = "https://static.com/";
        $fullUrl = new Url($staticUrl . $dir . $file);
        $staticFile = StaticFile::createFromUrl($fullUrl, $staticPath, $staticUrl);
        $staticFile->getLocalFileName();
    }

    public function testCreateFileFromWithLocalProperties()
    {
        $dir = 'dir/another/';
        $file = 'file.txt';
        $staticPath = '/var/www/';
        $staticUrl = "https://static.com/";
        $fullUrl = $staticUrl . $dir . $file;
        $staticFile = new StaticFile(
            $staticPath,
            $staticUrl,
            $dir,
            $file,
            'LOCAL_FILE_NAME',
            'LOCAL_FILE_PATH'
        );
        $this->assertEquals('LOCAL_FILE_NAME', $staticFile->getLocalFileName());

        $this->assertEquals('LOCAL_FILE_PATH', $staticFile->getLocalFullFilePath());
    }

    public function testStaticFileCreatedSuccessfullyFromUrlWithoutDirectory()
    {
        $dir = '';
        $file = 'file.txt';
        $staticPath = '/var/www/';
        $staticUrl = "https://static.com/";
        $fullUrl = new Url($staticUrl . $dir . $file);
        $staticFile = StaticFile::createFromUrl($fullUrl, $staticPath, $staticUrl);
        $this->assertEquals($fullUrl, $staticFile->getStaticFullUrl());
        $this->assertEquals($staticPath . $dir . $file, $staticFile->getStaticFullPath());
        $this->assertEquals($staticPath . $dir, $staticFile->getStaticDirectoryPath());
        $this->assertEquals($file, $staticFile->getStaticFileName());
    }
}
