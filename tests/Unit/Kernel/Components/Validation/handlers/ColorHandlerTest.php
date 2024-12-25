<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Validation\handlers\ColorHandler;
use Kernel\Components\Validation\rules\Color;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class ColorHandlerTest extends Unit
{
	public function testValidHEX()
	{
		$color = '#FF0033';
		$handler = new ColorHandler();
		$context = new ValidationContext();
		$result = $handler->validate($color, new Color(hex: true), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testInvalidHEX()
	{
		$color = '#FF0033';
		$handler = new ColorHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new Color(rgb: true);
		$result = $handler->validate($color, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testValidRGB()
	{
		$color = 'rgb(1,12,113)';
		$handler = new ColorHandler();
		$context = new ValidationContext();
		$result = $handler->validate($color, new Color(rgb: true), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testInvalidRGB()
	{
		$color = 'rgb(1,12,113)';
		$handler = new ColorHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new Color(hex: true);
		$result = $handler->validate($color, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testValidRGBOrHex()
	{
		$handler = new ColorHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new Color(hex: true, rgb: true);

		$color = 'rgb(1,12,113)';
		$result = $handler->validate($color, $rule, $context);
		$this->assertEmpty($result->getErrors());

		$color = '#FF0033';
		$result = $handler->validate($color, $rule, $context);
		$this->assertEmpty($result->getErrors());
	}

    public function testValidRGBOrHexDefault()
    {
        $handler = new ColorHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Color(hex: false, rgb: false);

        $color = 'rgb(1,12,113)';
        $result = $handler->validate($color, $rule, $context);
        $this->assertEmpty($result->getErrors());

        $color = '#FF0033';
        $result = $handler->validate($color, $rule, $context);
        $this->assertEmpty($result->getErrors());
    }

	public function testInvalidRGBOrHex()
	{
		$handler = new ColorHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new Color(hex: true, rgb: true);

		$color = 'not color';
		$result = $handler->validate($color, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

    public function testInvalidRGBOrHexDefault()
    {
        $handler = new ColorHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new Color(hex: false, rgb: false);

        $color = 'not color';
        $result = $handler->validate($color, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

	public function testWrongRuleTest()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new ColorHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('invalid color', $rule, $context);
	}

	public function testInvalidValueType()
	{
		$handler = new ColorHandler();
		$rule = new Color();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$result = $handler->validate(['invalid color'], $rule, $context);
		$errors = $result->getErrors();
		$this->assertCount(1, $errors);
		$this->assertEquals($rule->stringMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testInvalidHEXStart()
	{
		$color = '3#FF0033';
		$handler = new ColorHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new Color(hex: true);
		$result = $handler->validate($color, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testInvalidHEXEnd()
	{
		$color = '#FF0033)';
		$handler = new ColorHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new Color(hex: true);
		$result = $handler->validate($color, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testInvalidRGBStart()
	{
		$color = '0rgb(1,12,113)';
		$handler = new ColorHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new Color(rgb: true);
		$result = $handler->validate($color, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

	public function testInvalidRGBEnd()
	{
		$color = 'rgb(1,12,113)h';
		$handler = new ColorHandler();
		$context = new ValidationContext();
		$context->setAttribute('attributeName');
		$rule = new Color(rgb: true);
		$result = $handler->validate($color, $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$errors = $result->getErrors();
		$this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
		$this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
	}

    public function testMessageForColorTypes()
    {
        $rule = new Color();
        $this->assertEquals('Значение должно быть цветом. Формат цвета должен быть RGB или HEX', $rule->getMessage());


        $rule = new Color(hex: true);
        $this->assertEquals('Значение должно быть цветом. Формат цвета должен быть HEX', $rule->getMessage());


        $rule = new Color(rgb: true);
        $this->assertEquals('Значение должно быть цветом. Формат цвета должен быть RGB', $rule->getMessage());


        $rule = new Color(hex: true, rgb: true);
        $this->assertEquals('Значение должно быть цветом. Формат цвета должен быть RGB или HEX', $rule->getMessage());
    }
}