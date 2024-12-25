<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use InvalidArgumentException;
use Kernel\Components\Validation\handlers\CallbackHandler;
use Kernel\Components\Validation\handlers\FloatTypeHandler;
use Kernel\Components\Validation\handlers\IntegerTypeHandler;
use Kernel\Components\Validation\rules\Callback;
use Kernel\Components\Validation\rules\FloatType;
use Kernel\Components\Validation\rules\IntegerType;
use Yiisoft\Validator\Exception\InvalidCallbackReturnTypeException;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\ValidationContext;

class CallbackHandlerTest extends Unit
{
	public function testSuccessfulCallback()
	{
		$value = function (): Result {
			return new Result();
		};
		$handler = new CallbackHandler();
		$context = new ValidationContext();
		$result = $handler->validate([], new Callback(message: 'message', callback: $value), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testCallbackReturnsInvalidResult()
	{
		$this->expectException(InvalidCallbackReturnTypeException::class);
		$value = function () {
			return 'not valid result';
		};
		$handler = new CallbackHandler();
		$context = new ValidationContext();
		$result = $handler->validate([], new Callback(message: 'message', callback: $value), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testCallbackNotSet()
	{
		$this->expectException(InvalidArgumentException::class);
		$handler = new CallbackHandler();
		$context = new ValidationContext();
		$result = $handler->validate([], new Callback(message: 'message', method: 'string'), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testCallbackReturnErrors()
	{
		$value = function (): Result {
			return (new Result())->addError('someError');
		};
		$handler = new CallbackHandler();
		$context = new ValidationContext();
		$result = $handler->validate([], new Callback(message: 'message', callback:$value), $context);
		$this->assertNotEmpty($result->getErrors());
		$this->assertEquals('someError', $result->getErrors()[0]->getMessage());
	}

	public function testWrongRule()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new CallbackHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate(function (){}, $rule, $context);
	}
}