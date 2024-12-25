<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Validation\handlers\FloatTypeHandler;
use Kernel\Components\Validation\rules\FloatType;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class FloatTypeHandlerTest extends Unit
{
	public function testValidFloat()
	{
		$value = 3.14;
		$handler = new FloatTypeHandler();
		$context = new ValidationContext();
		$result = $handler->validate($value, new FloatType(), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testIntegerType()
	{
		$value = 3;
		$handler = new FloatTypeHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new FloatType(withInt: false);
		$result = $handler->validate($value, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testInvalidMin()
	{
		$value = 3;
		$handler = new FloatTypeHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new FloatType(min: 4);
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
		$handler = new FloatTypeHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new FloatType(max: 2);
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
		$handler = new FloatTypeHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new FloatType(min: 3, max: 3);
		$result = $handler->validate($value, $rule, $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testStringType()
	{
		$value = '3.14';
		$handler = new FloatTypeHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new FloatType();
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
		$handler = new FloatTypeHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('true', $rule, $context);
	}
}