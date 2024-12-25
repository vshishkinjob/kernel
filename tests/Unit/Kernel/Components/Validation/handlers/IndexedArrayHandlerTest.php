<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Validation\handlers\IndexArrayHandler;
use Kernel\Components\Validation\rules\IndexedArray;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;
use Yiisoft\Validator\Validator;

class IndexedArrayHandlerTest extends Unit
{
    public function testWrongRule()
    {
        $this->expectException(UnexpectedRuleException::class);
        $handler = new IndexArrayHandler();
        $rule = new class() {
        };
        $context = new ValidationContext();
        $handler->validate('true', $rule, $context);
    }

    public function testInvalidDataType()
    {
        $value = 13;
        $handler = new IndexArrayHandler();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $rule = new IndexedArray();
        $result = $handler->validate($value, $rule, $context);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->getIncorrectInputMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
        $this->assertEquals('int', $errors[0]->getParameters()['type']);
    }

    public function testCorrectIndexedArray()
    {
        $value = [12, '13', [14]];
        $result = (new Validator())->validate($value, new IndexedArray());
        $this->assertEmpty($result->getErrors());
    }

    public function testIncorrectIndexedArray()
    {
        $value = [12, 'test' => '13', [14]];
        $rule = new IndexedArray();
        $result = (new Validator())->validate($value, $rule);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals($rule->getIncorrectInputKeyMessage(), $errors[0]->getMessage());
        $this->assertEquals('array', $errors[0]->getParameters()['type']);
    }

    public function testEmptyArray()
    {
        $value = [];
        $rule = new IndexedArray();
        $result = (new Validator())->validate($value, $rule);
        $this->assertNotEmpty($result->getErrors());
        $errors = $result->getErrors();
        $this->assertEquals('Array is not allowed to be empty!', $errors[0]->getMessage());
        $this->assertEquals('array', $errors[0]->getParameters()['type']);
    }
}