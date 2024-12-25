<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Google\ReCaptcha3;
use Kernel\Components\Validation\handlers\FloatTypeHandler;
use Kernel\Components\Validation\handlers\IntegerTypeHandler;
use Kernel\Components\Validation\handlers\NumberLengthHandler;
use Kernel\Components\Validation\handlers\PaginationHandler;
use Kernel\Components\Validation\handlers\ReCaptcha3Handler;
use Kernel\Components\Validation\rules\FloatType;
use Kernel\Components\Validation\rules\IntegerType;
use Kernel\Components\Validation\rules\NumberLength;
use Kernel\Components\Validation\rules\Pagination;
use Kernel\Components\Validation\rules\ReCaptcha3 as ReCaptcha3Validator;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class ReCaptcha3HandlerTest extends Unit
{
	public function testValidPagination()
	{
		$value = 'some_captcha_token';
		$handler = new ReCaptcha3Handler($this->makeEmpty(ReCaptcha3::class, [
            'isValid' => true
        ]));
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new ReCaptcha3Validator();
		$result = $handler->validate($value, $rule, $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testWrongRule()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new ReCaptcha3Handler($this->makeEmpty(ReCaptcha3::class));
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('true', $rule, $context);
	}

    public function testInvalidType()
    {
        $value = 13;
        $handler = new ReCaptcha3Handler($this->makeEmpty(ReCaptcha3::class, [
            'isValid' => true
        ]));
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new ReCaptcha3Validator();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testInvalidRecaptcha()
    {
        $value = 'some_captcha_token';
        $handler = new ReCaptcha3Handler($this->makeEmpty(ReCaptcha3::class, [
            'isValid' => false
        ]));
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new ReCaptcha3Validator();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }
}