<?php

namespace Kernel\Components\Validation\rules;

use Closure;
use DateInterval;
use Kernel\Components\Helpers\DateHelper;
use Kernel\Components\Validation\handlers\DateRangeHandler;
use Kernel\Components\Validation\MessageValidationInterface;
use Yiisoft\Validator\EmptyCondition\NeverEmpty;
use Yiisoft\Validator\EmptyCondition\WhenMissing;
use Yiisoft\Validator\EmptyCondition\WhenNull;
use Yiisoft\Validator\Rule\Trait\SkipOnEmptyTrait;
use Yiisoft\Validator\Rule\Trait\WhenTrait;
use Yiisoft\Validator\RuleInterface;
use Yiisoft\Validator\SkipOnEmptyInterface;
use Yiisoft\Validator\WhenInterface;

final class DateRange implements RuleInterface, SkipOnEmptyInterface, MessageValidationInterface, WhenInterface
{
    use SkipOnEmptyTrait;
    use WhenTrait;

    public function __construct(
        public readonly string $message = 'Значение должно быть массивом.',
        public readonly ?string $format = null,
        public readonly ?DateInterval $maxInterval = null,
        public readonly bool $isDateFromRequired = false,
        public readonly bool $isDateToRequired = false,
        public readonly bool $lessThanCurrentTime = true,
        public readonly WhenMissing|NeverEmpty|WhenNull $skipOnEmpty = new NeverEmpty(),
        public Closure|null $when = null
    ) {
    }

    public function getName(): string
    {
        return 'dateRange';
    }

    public function getHandler(): string
    {
        return DateRangeHandler::class;
    }

    public function getMessage(): string
    {
        return $this->message
            . $this->getMessageRequired()
            . $this->getFormatMessage()
            . $this->getLessThanCurrentDateMessage()
            . $this->getMaxPeriodMessage();
    }

    public function getFormatMessage(): string
    {
        return $this->format !== null ? ' Значение даты/времени должно быть в формате: ' . $this->format : '';
    }

    public function getLessThanCurrentDateMessage(): string
    {
        return $this->lessThanCurrentTime ? " Значение dateTo не может быть больше текущего дня!" : '';
    }

    public function getMaxPeriodMessage(): string
    {
        return $this->maxInterval === null
            ? ''
            : " Разница между датами dateFrom и dateTo должна быть не более - "
            . DateHelper::getIntervalInWords($this->maxInterval);
    }

    private function getMessageRequired(): string
    {
        if ($this->isDateFromRequired || $this->isDateToRequired) {
            $message = 'Обязательные поля: '
                . ($this->isDateFromRequired ? 'dateFrom, ' : '')
                . ($this->isDateToRequired ? 'dateTo ' : '');
            return trim($message, ', ');
        }

        return ' Должно содержать хотя бы одно из двух полей: dateFrom, dateTo';
    }
}
