<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Validation\handlers\FloatTypeHandler;
use Kernel\Components\Validation\handlers\IntegerTypeHandler;
use Kernel\Components\Validation\handlers\NumberLengthHandler;
use Kernel\Components\Validation\rules\FloatType;
use Kernel\Components\Validation\rules\IntegerType;
use Kernel\Components\Validation\rules\NumberLength;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class NumberLengthHandlerTest extends Unit
{
	public function testValidNumberLength()
	{
		$value = 4000;
		$handler = new NumberLengthHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new NumberLength(min: 3, max: 5);
		$result = $handler->validate($value, $rule, $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testValidNumberLengthWithStringType()
	{
		$value = '4000';
		$handler = new NumberLengthHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new NumberLength(min: 3, max: 5);
		$result = $handler->validate($value, $rule, $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testInvalidMin()
	{
		$value = 40;
		$handler = new NumberLengthHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new NumberLength(min: 3);
		$result = $handler->validate($value, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->getMinMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testValidMinAndMaxStrictCompare()
	{
		$value = 300;
		$handler = new NumberLengthHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new NumberLength(min: 3, max: 3);
		$result = $handler->validate($value, $rule, $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testInvalidMax()
	{
		$value = '4000000';
		$handler = new NumberLengthHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new NumberLength(max: 3);
		$result = $handler->validate($value, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->getMaxMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testInvalidExactly()
	{
		$value = '40';
		$handler = new NumberLengthHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new NumberLength(exactly: 3);
		$result = $handler->validate($value, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->getExactlyMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testNotNumericValue()
	{
		$value = 'not numeric';
		$handler = new NumberLengthHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new NumberLength();
		$result = $handler->validate($value, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->message, $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testWrongRule()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new NumberLengthHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('true', $rule, $context);
	}
}