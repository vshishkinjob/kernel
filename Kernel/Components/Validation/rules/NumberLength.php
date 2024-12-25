<?php

namespace Kernel\Components\Validation\rules;

use Closure;
use Kernel\Components\Validation\handlers\NumberLengthHandler;
use Kernel\Components\Validation\MessageValidationInterface;
use Yiisoft\Validator\EmptyCondition\NeverEmpty;
use Yiisoft\Validator\EmptyCondition\WhenMissing;
use Yiisoft\Validator\EmptyCondition\WhenNull;
use Yiisoft\Validator\Rule\Trait\SkipOnEmptyTrait;
use Yiisoft\Validator\Rule\Trait\WhenTrait;
use Yiisoft\Validator\RuleInterface;
use Yiisoft\Validator\SkipOnEmptyInterface;
use Yiisoft\Validator\WhenInterface;

final class NumberLength implements RuleInterface, SkipOnEmptyInterface, MessageValidationInterface, WhenInterface
{
    use SkipOnEmptyTrait;
    use WhenTrait;

    public function __construct(
        public readonly ?int $exactly = null,
        public readonly ?int $min = null,
        public readonly ?int $max = null,
        public readonly string $message = 'Значение должно быть числом.',
        public readonly WhenMissing|NeverEmpty|WhenNull $skipOnEmpty = new NeverEmpty(),
        public Closure|null $when = null
    ) {
    }

    public function getName(): string
    {
        return 'numberLength';
    }

    public function getHandler(): string
    {
        return NumberLengthHandler::class;
    }

    public function getMessage(): string
    {
        $message = $this->message;

        if ($this->exactly !== null) {
            $message .= " " . $this->getExactlyMessage();
        }

        if ($this->min !== null) {
            $message .= " " . $this->getMinMessage();
        }

        if ($this->min !== null) {
            $message .= " " . $this->getMaxMessage();
        }

        return $message;
    }

    public function getMinMessage(): string
    {
        return "Длина числа должна быть не менее {$this->min} цифр";
    }

    public function getMaxMessage(): string
    {
        return "Длина числа должна быть не более {$this->max} цифр";
    }

    public function getExactlyMessage(): string
    {
        return "Длина числа должна быть ровно {$this->exactly} цифр";
    }
}
