<?php

namespace Unit\Kernel\Components\Repository\Tps\Annotation;

use Codeception\Test\Unit;
use DateTime;
use Kernel\Components\Exception\App\TypeCastException;
use Kernel\Components\Repository\Components\Tps\Annotation\TypeCast;
use Kernel\Enums\User\SubjectType;

class TypeCastTest extends Unit
{
    public function testEnumConvertationSuccess()
    {
        $value = SubjectType::SUB_AGENT->value;
        $type = SubjectType::class;
        $this->assertEquals(SubjectType::SUB_AGENT, TypeCast::cast($value, $type));
    }

    public function testEnumConvertationWithInvalidData()
    {
        $this->expectException(TypeCastException::class);
        $value = [SubjectType::SUB_AGENT->value];
        $type = SubjectType::class;
        TypeCast::cast($value, $type);
    }

    public function testDateTimeSuccess()
    {
        $value = "2024-01-12";
        $type = DateTime::class;
        $result = TypeCast::cast($value, $type);
        $this->assertInstanceOf(DateTime::class, $result);
        $this->assertEquals($value, $result->format("Y-m-d"));
    }

    public function testDateTimeFails()
    {
        $this->expectException(TypeCastException::class);
        $value = 13;
        $type = DateTime::class;
        TypeCast::cast($value, $type);
    }

    public function testTypeCastToIntSuccess()
    {
        $value = "13";
        $type = 'int';
        $result = TypeCast::cast($value, $type);
        $this->assertEquals(13, $result);
    }

    public function testTypeCastArrayToIntFails()
    {
        $this->expectException(TypeCastException::class);
        $value = [13];
        $type = 'int';
        TypeCast::cast($value, $type);
    }

    public function testTypeCastNotNumericToIntFails()
    {
        $this->expectException(TypeCastException::class);
        $value = 'TEXT';
        $type = 'int';
        TypeCast::cast($value, $type);
    }

    public function testTypeCastToFloatSuccess()
    {
        $value = "13.2";
        $type = 'float';
        $result = TypeCast::cast($value, $type);
        $this->assertEquals(13.2, $result);
    }

    public function testTypeCastArrayToFloatFails()
    {
        $this->expectException(TypeCastException::class);
        $value = [13];
        $type = 'float';
        TypeCast::cast($value, $type);
    }

    public function testTypeCastNotNumericToFloatFails()
    {
        $this->expectException(TypeCastException::class);
        $value = 'TEXT';
        $type = 'float';
        TypeCast::cast($value, $type);
    }

    public function testTypeCastToArraySuccess()
    {
        $value = 'TEXT';
        $type = 'array';
        $this->assertEquals(['TEXT'], TypeCast::cast($value, $type));
    }

    public function testDBoolSuccess()
    {
        $value = [1];
        $type = 'bool';
        $result = TypeCast::cast($value, $type);
        $this->assertEquals(true, $result);
    }
}