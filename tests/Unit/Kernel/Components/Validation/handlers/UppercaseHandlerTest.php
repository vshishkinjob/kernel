<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Validation\handlers\UppercaseHandler;
use Kernel\Components\Validation\rules\Uppercase;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class UppercaseHandlerTest extends Unit
{
	public function testValidString()
	{
		$value = 'ЗАГЛАВНЫЕ';
		$handler = new UppercaseHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new Uppercase();
		$result = $handler->validate($value, $rule, $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testWrongRule()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new UppercaseHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('true', $rule, $context);
	}

    public function testInvalidDataType()
    {
        $value = 13;
        $handler = new UppercaseHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Uppercase();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->stringMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testInvalidString()
    {
        $value = 'неЗаглавные';
        $handler = new UppercaseHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Uppercase();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }
}