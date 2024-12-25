<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Validation\handlers\FloatTypeHandler;
use Kernel\Components\Validation\handlers\IntegerTypeHandler;
use Kernel\Components\Validation\rules\FloatType;
use Kernel\Components\Validation\rules\IntegerType;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class IntegerTypeHandlerTest extends Unit
{
	public function testValidBool()
	{
		$value = 3;
		$handler = new IntegerTypeHandler();
		$context = new ValidationContext();
		$result = $handler->validate($value, new IntegerType(), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testInvalidMin()
	{
		$value = 3;
		$handler = new IntegerTypeHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new IntegerType(min: 4);
		$result = $handler->validate($value, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->getMinMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testInvalidMax()
	{
		$value = 3;
		$handler = new IntegerTypeHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new IntegerType(max: 2);
		$result = $handler->validate($value, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->getMaxMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testValidMinAndMaxStrictCompare()
	{
		$value = 3;
		$handler = new IntegerTypeHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new IntegerType(min: 3, max: 3);
		$result = $handler->validate($value, $rule, $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testStringIntegerType()
	{
		$value = '3';
		$handler = new IntegerTypeHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new IntegerType();
		$result = $handler->validate($value, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testWrongRule()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new IntegerTypeHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('true', $rule, $context);
	}
}