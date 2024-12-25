<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Validation\handlers\DateTimeFormatHandler;
use Kernel\Components\Validation\rules\DateTimeFormat;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;
use function Later\now;

class DateTimeFormatHandlerTest extends Unit
{
	public function testWithValidDate()
	{
		$date = '2024-12-11 13:00:00';
		$handler = new DateTimeFormatHandler();
		$context = new ValidationContext();
		$result = $handler->validate($date, new DateTimeFormat('Y-m-d H:i:s', lessThanCurrentTime: false), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testInvalidLessThanCurrentDate()
	{
		$date = date('Y-m-d H:i:s', strtotime("+1 day", time()));
		$handler = new DateTimeFormatHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new DateTimeFormat('Y-m-d H:i:s');
		$result = $handler->validate($date, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->lessDateMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testLessThanCurrentDate()
	{
		$date = date("Y-m-d") . ' 23:59:59';
		$handler = new DateTimeFormatHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new DateTimeFormat('Y-m-d H:i:s');
		$result = $handler->validate($date, $rule, $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testWithInvalidDate()
	{
		$date = '2024-12-11 13:00:00';
		$handler = new DateTimeFormatHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new DateTimeFormat('Y-m-d', lessThanCurrentTime: false);
		$result = $handler->validate($date, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testInvalidType()
	{
		$value = [];
		$handler = new DateTimeFormatHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new DateTimeFormat();
		$result = $handler->validate($value, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->stringMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testWrongRule()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new DateTimeFormatHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('true', $rule, $context);
	}
}