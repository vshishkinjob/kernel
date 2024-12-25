<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Validation\handlers\BICHandler;
use Kernel\Components\Validation\rules\BIC;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class BICHandlerTest extends Unit
{
	public function testValidBIC()
	{
		$bic = 'HBUKGB4B';
		$handler = new BICHandler();
		$context = new ValidationContext();
		$result = $handler->validate($bic, new BIC(), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testInvalidBIC()
	{
		$bic = 'hBUKGB4B';
		$handler = new BICHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new BIC();
		$result = $handler->validate($bic, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testWrongRule()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new BICHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('invalid bic', $rule, $context);
	}

	public function testInvalidValueType()
	{
		$handler = new BICHandler();
		$rule = new BIC();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$result = $handler->validate(['invalid bic'], $rule, $context);
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->stringMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testBase64WithInvalidRegexStartString()
	{
		$bic = 'aHBUKGB4B';
		$handler = new BICHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new BIC();
		$result = $handler->validate($bic, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testBase64WithInvalidRegexEndString()
	{
		$bic = 'HBUKGB4Ba';
		$handler = new BICHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new BIC();
		$result = $handler->validate($bic, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

}