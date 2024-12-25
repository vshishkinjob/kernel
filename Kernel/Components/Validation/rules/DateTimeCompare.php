<?php

namespace Kernel\Components\Validation\rules;

use Closure;
use DateInterval;
use Kernel\Components\Validation\handlers\DateTimeCompareHandler;
use Kernel\Components\Validation\MessageValidationInterface;
use Kernel\Enums\CompareOperator;
use Yiisoft\Validator\Rule\Trait\WhenTrait;
use Yiisoft\Validator\RuleInterface;
use Yiisoft\Validator\WhenInterface;

final class DateTimeCompare implements RuleInterface, MessageValidationInterface, WhenInterface
{
    use WhenTrait;

    public function __construct(
        public readonly string $firstAttributeName,
        public readonly string $secondAttributeName,
        public readonly CompareOperator $operator = CompareOperator::MORE,
        public readonly ?DateInterval $maxInterval = null,
        public Closure|null $when = null
    ) {
    }

    public function getName(): string
    {
        return 'dateTimeCompare';
    }

    public function getHandler(): string
    {
        return DateTimeCompareHandler::class;
    }

    public function getMessage(): string
    {
        return "$this->firstAttributeName должен быть {$this->getOperatorMessage()} $this->secondAttributeName";
    }

    public function stringMessage(): string
    {
        return "Значение должно быть строкой.";
    }

    private function getOperatorMessage(): string
    {
        return match ($this->operator) {
            CompareOperator::MORE           => "больше чем",
            CompareOperator::MORE_OR_EQUAL  => "больше или равно",
            CompareOperator::LESS           => "меньше чем",
            CompareOperator::LESS_OR_EQUAL  => "меньше или равно",
            CompareOperator::EQUAL          => "равен",
            CompareOperator::NOT_EQUAL      => "не равен"
        };
    }
}
