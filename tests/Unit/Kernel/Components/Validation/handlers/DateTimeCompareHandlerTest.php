<?php

namespace Unit\Kernel\Components\Validation\handlers;

use Codeception\Test\Unit;
use Kernel\Components\Exception\App\NotValidEntityException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\Validation\handlers\ColorHandler;
use Kernel\Components\Validation\handlers\DateTimeCompareHandler;
use Kernel\Components\Validation\rules\DateTimeCompare;
use Kernel\Enums\CompareOperator;
use Yiisoft\Validator\DataSetInterface;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\ValidationContext;

class DateTimeCompareHandlerTest extends Unit
{
	public function testValidDateTimesOnLess()
	{
		$firstDate = '2015-01-01 12:30:12';
		$secondDate = '2016-01-01 12:30:12';
		$handler = new DateTimeCompareHandler();
		$context = $this->getContext($firstDate, $secondDate);
		$result = $handler->validate([], new DateTimeCompare('firstDate', 'secondDate', CompareOperator::LESS), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testInValidDateTimesOnLess()
	{
		$firstDate = '2016-01-01 12:30:12';
		$secondDate = '2015-01-01 12:30:12';
		$handler = new DateTimeCompareHandler();
		$context = $this->getContext($firstDate, $secondDate);
		$rule = new DateTimeCompare('firstDate', 'secondDate', CompareOperator::LESS);
		$result = $handler->validate([], $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$this->assertEquals($rule->getMessage(), $result->getErrors()[0]->getMessage());
	}

	public function testValidDateTimesOnBigger()
	{
		$firstDate = '2016-01-01 12:30:12';
		$secondDate = '2015-01-01 12:30:12';
		$handler = new DateTimeCompareHandler();
		$context = $this->getContext($firstDate, $secondDate);
		$result = $handler->validate([], new DateTimeCompare('firstDate', 'secondDate', CompareOperator::MORE), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testInvalidDateTimesOnBigger()
	{
		$firstDate = '2015-01-01 12:30:12';
		$secondDate = '2016-01-01 12:30:12';
		$handler = new DateTimeCompareHandler();
		$rule = new DateTimeCompare('firstDate', 'secondDate', CompareOperator::MORE);
		$context = $this->getContext($firstDate, $secondDate);
		$result = $handler->validate([], $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$this->assertEquals($rule->getMessage(), $result->getErrors()[0]->getMessage());
	}

	public function testValidDateTimesOnBiggerOrEqual()
	{
		$firstDate = '2015-01-01 12:30:12';
		$secondDate = '2015-01-01 12:30:12';
		$handler = new DateTimeCompareHandler();
		$context = $this->getContext($firstDate, $secondDate);
		$result = $handler->validate([], new DateTimeCompare('firstDate', 'secondDate', CompareOperator::MORE_OR_EQUAL), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testInvalidDateTimesOnBiggerOrEqual()
	{
		$firstDate = '2015-01-01 12:30:11';
		$secondDate = '2015-01-01 12:30:12';
		$handler = new DateTimeCompareHandler();
		$rule = new DateTimeCompare('firstDate', 'secondDate', CompareOperator::MORE_OR_EQUAL);
		$context = $this->getContext($firstDate, $secondDate);
		$result = $handler->validate([], $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$this->assertEquals($rule->getMessage(), $result->getErrors()[0]->getMessage());
	}

	public function testValidDateTimesOnLessOrEqual()
	{
		$firstDate = '2015-01-01 12:30:12';
		$secondDate = '2015-01-01 12:30:12';
		$handler = new DateTimeCompareHandler();
		$context = $this->getContext($firstDate, $secondDate);
		$result = $handler->validate([], new DateTimeCompare('firstDate', 'secondDate', CompareOperator::LESS_OR_EQUAL), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testInvalidDateTimesOnLessOrEqual()
	{
		$firstDate = '2015-01-01 12:30:13';
		$secondDate = '2015-01-01 12:30:12';
		$handler = new DateTimeCompareHandler();
		$rule = new DateTimeCompare('firstDate', 'secondDate', CompareOperator::LESS_OR_EQUAL);
		$context = $this->getContext($firstDate, $secondDate);
		$result = $handler->validate([], $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$this->assertEquals($rule->getMessage(), $result->getErrors()[0]->getMessage());
	}

	public function testValidDateTimesOnEqual()
	{
		$firstDate = '2015-01-01 12:30:12';
		$secondDate = '2015-01-01 12:30:12';
		$handler = new DateTimeCompareHandler();
		$context = $this->getContext($firstDate, $secondDate);
		$result = $handler->validate([], new DateTimeCompare('firstDate', 'secondDate', CompareOperator::EQUAL), $context);
		$this->assertEmpty($result->getErrors());
	}

	public function testInvalidDateTimesOnEqual()
	{
		$firstDate = '2015-01-01 12:30:13';
		$secondDate = '2015-01-01 12:30:12';
		$handler = new DateTimeCompareHandler();
		$context = $this->getContext($firstDate, $secondDate);
		$rule = new DateTimeCompare('firstDate', 'secondDate', CompareOperator::EQUAL);
		$result = $handler->validate([], $rule, $context);
		$this->assertNotEmpty($result->getErrors());
		$this->assertEquals($rule->getMessage(), $result->getErrors()[0]->getMessage());
	}

	public function testInvalidDateTimes()
	{
		$firstDate = 'invalid data';
		$secondDate = '2015-01-01 12:30:12';
		$handler = new DateTimeCompareHandler();
		$context = $this->getContext($firstDate, $secondDate);
		$result = $handler->validate([], new DateTimeCompare('firstDate', 'secondDate', CompareOperator::LESS_OR_EQUAL), $context);
		$this->assertNotEmpty($result->getErrors());
		$this->assertEquals("firstDate не является допустимой датой!", $result->getErrors()[0]->getMessage());
	}

	public function testWrongRuleTest()
	{
		$this->expectException(UnexpectedRuleException::class);
		$handler = new DateTimeCompareHandler();
		$rule = new class() {
		};
		$context = new ValidationContext();
		$handler->validate('invalid date', $rule, $context);
	}

	public function testInvalidInterval()
	{
		$firstDate = '2015-01-01 12:30:12';
		$secondDate = '2017-03-01 12:30:12';
		$handler = new DateTimeCompareHandler();
		$context = $this->getContext($firstDate, $secondDate);
		$result = $handler->validate([], new DateTimeCompare(
			'firstDate',
			'secondDate',
			CompareOperator::LESS,
			new \DateInterval("P1Y2M3DT4H5M10S")), $context
		);
		$this->assertNotEmpty($result->getErrors());
		$this->assertEquals(
			"Разница между датами firstDate и secondDate должна быть не более - 1 лет 2 месяцев 3 дней 4 часов 5 минут 10 секунд",
			$result->getErrors()[0]->getMessage()
		);
	}

	private function getContext(string $firstDate, string $secondDate): ValidationContext
	{
		return $this->make(ValidationContext::class, [
			'getGlobalDataSet' => $this->makeEmpty(DataSetInterface::class, [
				'getAttributeValue' => function (string $attribute) use ($firstDate, $secondDate) {
					if ($attribute === 'firstDate') {
						return $firstDate;
					} elseif ($attribute === 'secondDate') {
						return $secondDate;
					}
				}
			])
		]);
	}
}