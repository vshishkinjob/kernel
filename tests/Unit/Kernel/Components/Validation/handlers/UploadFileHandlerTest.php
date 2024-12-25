<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\File\FileHelper;
use Kernel\Components\Validation\handlers\UploadedFileHandler;
use Kernel\Components\Validation\rules\UploadedFile;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class UploadFileHandlerTest extends Unit
{
    public function testWrongRule()
    {
        $this->expectException(UnexpectedRuleException::class);
        $handler = new UploadedFileHandler(new FileHelper());
        $rule = new class() {
        };
        $context = new ValidationContext();
        $handler->validate('true', $rule, $context);
    }

    public function testInvalidDataType()
    {
        $value = 13;
        $handler = new UploadedFileHandler(new FileHelper());
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new UploadedFile();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals("Некорректный формат файла!", $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testCorrectBase64File()
    {
        $value = file_get_contents(__DIR__ . '/../../File/image.txt');
        $handler = new UploadedFileHandler(new FileHelper());
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new UploadedFile();
        $result = $handler->validate($value, $rule, $context);
        $this->assertEmpty($result->getErrors());
    }

    public function testIncorrectBase64File()
    {
        $value = 'not_base64';
        $handler = new UploadedFileHandler(new FileHelper());
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new UploadedFile();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals("Не удалось создать файл из Base64 строки!", $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testCorrectPsrFile()
    {
        $value = $this->makeEmpty(UploadedFileInterface::class, [
            'getStream' => $this->makeEmpty(StreamInterface::class, [
                'getMetadata' => __DIR__ . '/../../File/image.txt'
            ]),
            'getSize' => 100
        ]);
        $handler = new UploadedFileHandler(new FileHelper());
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new UploadedFile(extension: 'txt', maxSize: 100, minSize: 100);
        $result = $handler->validate($value, $rule, $context);
        $this->assertEmpty($result->getErrors());
    }

    public function testIncorrectExtension()
    {
        $value = $this->makeEmpty(UploadedFileInterface::class, [
            'getStream' => $this->makeEmpty(StreamInterface::class, [
                'getMetadata' => __DIR__ . '/../../File/image.txt'
            ])
        ]);
        $handler = new UploadedFileHandler(new FileHelper());
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new UploadedFile(extension: 'png');
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals("Файл должен быть в формате: png", $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testIncorrectMinSize()
    {
        $value = $this->makeEmpty(UploadedFileInterface::class, [
            'getSize' => 99
        ]);
        $handler = new UploadedFileHandler(new FileHelper());
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new UploadedFile(minSize: 100);
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals("Файл должен быть не менее 100 байт", $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testIncorrectMaxSize()
    {
        $value = $this->makeEmpty(UploadedFileInterface::class, [
            'getSize' => 101
        ]);
        $handler = new UploadedFileHandler(new FileHelper());
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new UploadedFile(maxSize: 100);
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals("Файл должен быть не более 100 байт", $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testFailToGetFileSizeMax()
    {
        $value = $this->makeEmpty(UploadedFileInterface::class, [
            'getSize' => false
        ]);
        $handler = new UploadedFileHandler(new FileHelper());
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new UploadedFile(maxSize: 100);
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals("Не удалось определить размер файла!", $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testFailToGetFileSizeMin()
    {
        $value = $this->makeEmpty(UploadedFileInterface::class, [
            'getSize' => false
        ]);
        $handler = new UploadedFileHandler(new FileHelper());
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new UploadedFile(minSize: 100);
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals("Не удалось определить размер файла!", $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testFailToGetFileSizeMinMax()
    {
        $value = $this->makeEmpty(UploadedFileInterface::class, [
            'getSize' => false
        ]);
        $handler = new UploadedFileHandler(new FileHelper());
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new UploadedFile(maxSize: 100, minSize: 100);
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals("Не удалось определить размер файла!", $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }
}