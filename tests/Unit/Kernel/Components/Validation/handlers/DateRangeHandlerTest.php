<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use DateInterval;
use Kernel\Components\Validation\handlers\DateRangeHandler;
use Kernel\Components\Validation\rules\DateRange;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class DateRangeHandlerTest extends Unit
{
	public function testWrongRuleTest()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new DateRangeHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('invalid base64', $rule, $context);
	}

    public function testInvalidValueType()
    {
        $handler = new DateRangeHandler();
        $rule = new DateRange();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $result = $handler->validate('string', $rule, $context);
        $errors = $result->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testArrayKeysHasInvalidKey()
    {
        $handler = new DateRangeHandler();
        $rule = new DateRange();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $result = $handler->validate(['notDateFrom' => '2023-11-01', 'dateTo' => '2023-11-02'], $rule, $context);
        $errors = $result->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals("В временном диапазоне указано некорректное поле notDateFrom!", $errors[0]->getMessage());
        $this->assertEquals('notDateFrom', $errors[0]->getParameters()['attribute']);
    }

    public function testArrayHasNotASingleKey()
    {
        $handler = new DateRangeHandler();
        $rule = new DateRange();
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $result = $handler->validate(['notDateFrom' => '2023-11-01', 'notDateTo' => '2023-11-02'], $rule, $context);
        $errors = $result->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testArrayHasNotRequiredDateFrom()
    {
        $handler = new DateRangeHandler();
        $rule = new DateRange(isDateFromRequired: true);
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $result = $handler->validate(['notDateFrom' => '2023-11-01', 'dateTo' => '2023-11-02'], $rule, $context);
        $errors = $result->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testArrayHasNotRequiredDateTo()
    {
        $handler = new DateRangeHandler();
        $rule = new DateRange(isDateToRequired: true);
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $result = $handler->validate(['dateFrom' => '2023-11-01', 'notDateTo' => '2023-11-02'], $rule, $context);
        $errors = $result->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals($rule->getMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testSuccessValidation()
    {
        $handler = new DateRangeHandler();
        $rule = new DateRange(format: "Y-m-d H:i:s", maxInterval: new DateInterval("P32D"));
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $result = $handler->validate(['dateFrom' => '2023-10-01 00:00:00'], $rule, $context);
        $this->assertTrue($result->isValid());
    }

    public function testInvalidFormat()
    {
        $handler = new DateRangeHandler();
        $rule = new DateRange(format: "Y-m-d H:i:s", maxInterval: new DateInterval("P32D"));
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $result = $handler->validate(['dateFrom' => '2023-10-01', 'dateTo' => '2023-11-01 00:00:01'], $rule, $context);
        $errors = $result->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals('Значение должно быть строкой в формате даты/времени. Формат строки: Y-m-d H:i:s', $errors[0]->getMessage());
        $this->assertEquals('dateFrom', $errors[0]->getParameters()['attribute']);
    }

    public function testInvalidMaxInterval()
    {
        $handler = new DateRangeHandler();
        $rule = new DateRange(format: "Y-m-d H:i:s", maxInterval: new DateInterval("P32D"));
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $result = $handler->validate(['dateFrom' => '2023-10-01 00:00:01', 'dateTo' => '2023-12-01 00:00:01'], $rule, $context);
        $errors = $result->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals($rule->getMaxPeriodMessage(), $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }

    public function testDateFromIsLessThanDateTo()
    {
        $handler = new DateRangeHandler();
        $rule = new DateRange(format: "Y-m-d H:i:s", maxInterval: new DateInterval("P32D"));
        $context = new ValidationContext();
        $context->setAttribute('attributeName');
        $result = $handler->validate(['dateFrom' => '2023-11-01 00:00:01', 'dateTo' => '2023-10-01 00:00:01'], $rule, $context);
        $errors = $result->getErrors();
        $this->assertCount(1, $errors);
        $this->assertEquals("dateFrom должно быть больше или равно dateTo!", $errors[0]->getMessage());
        $this->assertEquals('attributeName', $errors[0]->getParameters()['attribute']);
    }
}