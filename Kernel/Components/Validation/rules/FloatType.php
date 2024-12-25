<?php

namespace Kernel\Components\Validation\rules;

use Closure;
use Kernel\Components\Validation\handlers\FloatTypeHandler;
use Kernel\Components\Validation\MessageValidationInterface;
use Yiisoft\Validator\EmptyCondition\NeverEmpty;
use Yiisoft\Validator\EmptyCondition\WhenMissing;
use Yiisoft\Validator\EmptyCondition\WhenNull;
use Yiisoft\Validator\Rule\Trait\SkipOnEmptyTrait;
use Yiisoft\Validator\Rule\Trait\WhenTrait;
use Yiisoft\Validator\RuleInterface;
use Yiisoft\Validator\SkipOnEmptyInterface;
use Yiisoft\Validator\WhenInterface;

final class FloatType implements RuleInterface, SkipOnEmptyInterface, MessageValidationInterface, WhenInterface
{
    use SkipOnEmptyTrait;
    use WhenTrait;

    public function __construct(
        public readonly float|null $min = null,
        public readonly float|null $max = null,
        public readonly bool $withInt = true,
        public readonly string $message = 'Значение должно быть вещественным числом.',
        public readonly WhenMissing|NeverEmpty|WhenNull $skipOnEmpty = new NeverEmpty(),
        public Closure|null $when = null
    ) {
    }

    public function getName(): string
    {
        return 'floatType';
    }

    public function getHandler(): string
    {
        return FloatTypeHandler::class;
    }

    public function getMessage(): string
    {
        $message = $this->message;

        if (!$this->withInt) {
            $message .= " " . $this->getWithIntMessage();
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
        return "Значение должно быть не менее: {$this->min}";
    }

    public function getMaxMessage(): string
    {
        return "Значение должно быть не более: {$this->max}";
    }

    private function getWithIntMessage(): string
    {
        return "Значение не должно содержать целые числа.";
    }
}
