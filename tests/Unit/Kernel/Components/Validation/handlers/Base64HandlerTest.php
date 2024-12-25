<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Validation\handlers\Base64Handler;
use Kernel\Components\Validation\rules\Base64;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class Base64HandlerTest extends Unit
{
	public function testValidBase64()
	{
		$base64 = file_get_contents(__DIR__ . '/../../File/image.txt');
		$handler = new Base64Handler();
		$context = new ValidationContext();
		$result = $handler->validate($base64, new Base64(), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testBase64WithInvalidRegexStartString()
	{
		$base64 = file_get_contents(__DIR__ . '/../../File/image.txt');
		$base64 = '%a' . $base64 . 'xx';
		$handler = new Base64Handler();
		$context = new ValidationContext();
		$rule = new Base64();
		$context->setAttribute('attributeName');
		$result = $handler->validate($base64, $rule, $context);
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->message, $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testBase64WithInvalidRegexEndString()
	{
		$base64 = file_get_contents(__DIR__ . '/../../File/image.txt');
		$base64 = 'aa' . $base64 . 'x%';
		$handler = new Base64Handler();
		$context = new ValidationContext();
		$rule = new Base64();
		$context->setAttribute('attributeName');
		$result = $handler->validate($base64, $rule, $context);
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->message, $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testInvalidBase64()
	{
		$handler = new Base64Handler();
		$rule = new Base64();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$result = $handler->validate('invalid base64', $rule, $context);
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->message, $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testWrongRuleTest()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new Base64Handler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('invalid base64', $rule, $context);
	}

	public function testInvalidValueType()
	{
		$handler = new Base64Handler();
		$rule = new Base64();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$result = $handler->validate(['invalid base64'], $rule, $context);
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->stringMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}
}