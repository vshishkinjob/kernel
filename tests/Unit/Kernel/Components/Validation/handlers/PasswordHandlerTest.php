<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Validation\handlers\PasswordHandler;
use Kernel\Components\Validation\rules\Password;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class PasswordHandlerTest extends Unit
{
	public function testValidPassword()
	{
		$value = '@Passw0rd';
		$handler = new PasswordHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new Password();
		$result = $handler->validate($value, $rule, $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testWrongRule()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new PasswordHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('true', $rule, $context);
	}

    public function testInvalidDataType()
    {
        $value = 13;
        $handler = new PasswordHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Password();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->stringMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testInvalidPassword()
    {
        $value = 'asd!@#$%^&*()_+';
        $handler = new PasswordHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Password();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }
}