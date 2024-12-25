<?php

namespace Kernel\Components\Validation\rules;

use Closure;
use Kernel\Components\Validation\handlers\DateTimeFormatHandler;
use Kernel\Components\Validation\MessageValidationInterface;
use Yiisoft\Validator\EmptyCondition\NeverEmpty;
use Yiisoft\Validator\EmptyCondition\WhenMissing;
use Yiisoft\Validator\EmptyCondition\WhenNull;
use Yiisoft\Validator\Rule\Trait\SkipOnEmptyTrait;
use Yiisoft\Validator\Rule\Trait\WhenTrait;
use Yiisoft\Validator\RuleInterface;
use Yiisoft\Validator\SkipOnEmptyInterface;
use Yiisoft\Validator\WhenInterface;

final class DateTimeFormat implements RuleInterface, SkipOnEmptyInterface, MessageValidationInterface, WhenInterface
{
    use SkipOnEmptyTrait;
    use WhenTrait;

    public function __construct(
        public readonly ?string $format = "Y-m-d",
        public readonly string $message = 'Значение должно быть строкой в формате даты/времени.',
        public readonly WhenMissing|NeverEmpty|WhenNull $skipOnEmpty = new NeverEmpty(),
        public readonly bool $lessThanCurrentTime = true,
        public Closure|null $when = null
    ) {
    }

    public function getName(): string
    {
        return 'dateTimeFormat';
    }

    public function getHandler(): string
    {
        return DateTimeFormatHandler::class;
    }

    public function getMessage(): string
    {
        return $this->message . ($this->format !== null ? ' Формат строки: ' . $this->format : '');
    }

	public function stringMessage(): string
	{
		return "Значение должно быть строкой.";
	}

	public function lessDateMessage(): string
	{
		return "Дата не может быть больше текущего дня!";
	}
}
