<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Validation\handlers\BooleanTypeHandler;
use Kernel\Components\Validation\rules\BooleanType;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class BooleanTypeHandlerTest extends Unit
{
	public function testValidBool()
	{
		$bool = true;
		$handler = new BooleanTypeHandler();
		$context = new ValidationContext();
		$result = $handler->validate($bool, new BooleanType(), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testInvalidBool()
	{
		$bool = 'true';
		$handler = new BooleanTypeHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new BooleanType();
		$result = $handler->validate($bool, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testWrongRule()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new BooleanTypeHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('true', $rule, $context);
	}
}