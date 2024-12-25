<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Validation\handlers\PhoneHandler;
use Kernel\Components\Validation\rules\Phone;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class PhoneHandlerTest extends Unit
{
	public function testValidPassword()
	{
		$value = '+7 (777) 777 7777';
		$handler = new PhoneHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new Phone();
		$result = $handler->validate($value, $rule, $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testWrongRule()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new PhoneHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('true', $rule, $context);
	}

    public function testInvalidDataType()
    {
        $value = 13;
        $handler = new PhoneHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Phone();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->stringMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testInvalidPhone()
    {
        $value = 'not_phone';
        $handler = new PhoneHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Phone();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }
}