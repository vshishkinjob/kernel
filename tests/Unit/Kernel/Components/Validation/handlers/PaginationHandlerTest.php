<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Validation\handlers\FloatTypeHandler;
use Kernel\Components\Validation\handlers\IntegerTypeHandler;
use Kernel\Components\Validation\handlers\NumberLengthHandler;
use Kernel\Components\Validation\handlers\PaginationHandler;
use Kernel\Components\Validation\rules\FloatType;
use Kernel\Components\Validation\rules\IntegerType;
use Kernel\Components\Validation\rules\NumberLength;
use Kernel\Components\Validation\rules\Pagination;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class PaginationHandlerTest extends Unit
{
	public function testValidPagination()
	{
		$value = ['limit' => 20, 'offset' => 0];
		$handler = new PaginationHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new Pagination();
		$result = $handler->validate($value, $rule, $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testWrongRule()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new PaginationHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('true', $rule, $context);
	}

    public function testInvalidDataType()
    {
        $value = 13;
        $handler = new PaginationHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Pagination();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
        $this->assertEquals('int', $errors[0]->getParameters()['type']);
    }

    public function testInvalidMissingLimit()
    {
        $value = ['offset' => 0];
        $handler = new PaginationHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Pagination();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
        $this->assertEquals('array', $errors[0]->getParameters()['type']);
    }

    public function testInvalidMissingOffset()
    {
        $value = ['limit' => 20];
        $handler = new PaginationHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Pagination();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testExtraField()
    {
        $value = ['EXTRA_FIELD' => 20, 'limit' => 20, 'offset' => 0];
        $handler = new PaginationHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Pagination();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals('Указанно некорректное поле EXTRA_FIELD', $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
        $this->assertEquals('array', $errors[0]->getParameters()['type']);
    }

    public function testInvalidLimitType()
    {
        $value = ['limit' => '20', 'offset' => 0];
        $handler = new PaginationHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Pagination();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
        $this->assertEquals('array', $errors[0]->getParameters()['type']);
    }

    public function testInvalidOffsetType()
    {
        $value = ['limit' => 20, 'offset' => '0'];
        $handler = new PaginationHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Pagination();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
        $this->assertEquals('array', $errors[0]->getParameters()['type']);
    }

    public function testValidLimitMaxValue()
    {
        $rule = new Pagination();
        $value = ['limit' => $rule->maxInt, 'offset' => 0];
        $handler = new PaginationHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $result = $handler->validate($value, $rule, $context);
        $this->assertEmpty($result->getErrors());
    }

    public function testValidOffsetMaxValue()
    {
        $rule = new Pagination();
        $value = ['limit' => 20, 'offset' => $rule->maxInt];
        $handler = new PaginationHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $result = $handler->validate($value, $rule, $context);
        $this->assertEmpty($result->getErrors());
    }
}