<?php

namespace Unit\Kernel\Components\Method;

use Codeception\Test\Unit;
use DateTime;
use DateTimeImmutable;
use Kernel\Components\Exception\App\TypeCastException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\File\UploadFile\KernelUploadedFileInterface;
use Kernel\Components\File\UploadFile\PsrUploadedFile;
use Kernel\Components\File\UploadFile\SplUploadedFile;
use Kernel\Components\File\UploadFile\UploadedFileCollection;
use Kernel\Components\Helpers\ObjectTypeCast;
use Kernel\Components\Response\HttpResponseCode;
use Kernel\Enums\User\SubjectType;
use Kernel\ValueObjects\Email;
use Kernel\ValueObjects\EmailCollection;
use Psr\Http\Message\UploadedFileInterface;

class ObjectTypeCastTest extends Unit
{
    public function testEnumConvertationSuccess()
    {
        $value = SubjectType::SUB_AGENT->value;
        $type = SubjectType::class;
        $this->assertEquals(SubjectType::SUB_AGENT, ObjectTypeCast::convertValueToObject($value, $type));
    }

    public function testEnumConvertationWithInvalidData()
    {
        $this->expectException(TypeCastException::class);
        $value = [SubjectType::SUB_AGENT->value];
        $type = SubjectType::class;
        ObjectTypeCast::convertValueToObject($value, $type);
    }

    public function testEnumCollectionConvertationSuccess()
    {
        $value = [HttpResponseCode::RequestTimeout->value, HttpResponseCode::InternalServerError->value];
        $type = MockEnumCollection::class;
        $this->assertEquals(
            $value,
            ObjectTypeCast::convertValueToObject($value, $type)->getAllValues()
        );
    }

    public function testEnumCollectionConvertationWithInvalidData()
    {
        $this->expectException(TypeCastException::class);
        $value = HttpResponseCode::RequestTimeout->value;
        $type = MockEnumCollection::class;
        ObjectTypeCast::convertValueToObject($value, $type);
    }

    public function testUploadedFileForStringSuccess()
    {
        $value = file_get_contents(__DIR__ . '/../File/image.txt');
        $type = KernelUploadedFileInterface::class;
        $this->assertInstanceOf(SplUploadedFile::class, ObjectTypeCast::convertValueToObject($value, $type));
    }

    public function testUploadedFileForPsrSuccess()
    {
        $value = $this->makeEmpty(UploadedFileInterface::class);
        $type = KernelUploadedFileInterface::class;
        $this->assertInstanceOf(PsrUploadedFile::class, ObjectTypeCast::convertValueToObject($value, $type));
    }

    public function testUploadedFileFails()
    {
        $this->expectException(TypeCastException::class);
        $value = 13;
        $type = KernelUploadedFileInterface::class;
        ObjectTypeCast::convertValueToObject($value, $type);
    }

    public function testUploadedFileCollectionSuccess()
    {
        $value = [$this->makeEmpty(UploadedFileInterface::class), file_get_contents(__DIR__ . '/../File/image.txt')];
        $type = UploadedFileCollection::class;
        $result = ObjectTypeCast::convertValueToObject($value, $type);
        $this->assertInstanceOf(UploadedFileCollection::class, $result);
        $this->assertCount(2, $result);
    }

    public function testUploadedFileCollectionFails()
    {
        $this->expectException(TypeCastException::class);
        $value = 13;
        $type = UploadedFileCollection::class;
        ObjectTypeCast::convertValueToObject($value, $type);
    }

    public function testDateTimeSuccess()
    {
        $value = "2024-01-12";
        $type = DateTime::class;
        $result = ObjectTypeCast::convertValueToObject($value, $type);
        $this->assertInstanceOf(DateTime::class, $result);
        $this->assertEquals($value, $result->format("Y-m-d"));
    }

    public function testDateTimeFails()
    {
        $this->expectException(TypeCastException::class);
        $value = 13;
        $type = DateTime::class;
        ObjectTypeCast::convertValueToObject($value, $type);
    }

    public function testDateTimeImmutableSuccess()
    {
        $value = "2024-01-12";
        $type = DateTimeImmutable::class;
        $result = ObjectTypeCast::convertValueToObject($value, $type);
        $this->assertInstanceOf(DateTimeImmutable::class, $result);
        $this->assertEquals($value, $result->format("Y-m-d"));
    }

    public function testDateTimeImmutableFails()
    {
        $this->expectException(TypeCastException::class);
        $value = 13;
        $type = DateTimeImmutable::class;
        ObjectTypeCast::convertValueToObject($value, $type);
    }

    public function testValueObjectSuccess()
    {
        $value = 'some@email.test';
        $type = Email::class;
        $result = ObjectTypeCast::convertValueToObject($value, $type);
        $this->assertInstanceOf($type, $result);
        $this->assertEquals($value, $result->getValue());
    }

    public function testValueObjectFails()
    {
        $this->expectException(ValidationException::class);
        $value = 12;
        $type = Email::class;
        ObjectTypeCast::convertValueToObject($value, $type);
    }

    public function testValueObjectCollectionSuccess()
    {
        $value = ['some@email.test', 'another@email.com'];
        $type = EmailCollection::class;
        $result = ObjectTypeCast::convertValueToObject($value, $type);
        $this->assertInstanceOf(EmailCollection::class, $result);
        $this->assertCount(2, $result);
    }

    public function testValueObjectCollectionFails()
    {
        $this->expectException(TypeCastException::class);
        $value = 12;
        $type = EmailCollection::class;
        ObjectTypeCast::convertValueToObject($value, $type);
    }
}
