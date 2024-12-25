<?php

namespace Kernel\Components\Validation\rules;

use Closure;
use Kernel\Components\Validation\handlers\UppercaseHandler;
use Kernel\Components\Validation\MessageValidationInterface;
use Yiisoft\Validator\EmptyCondition\NeverEmpty;
use Yiisoft\Validator\EmptyCondition\WhenMissing;
use Yiisoft\Validator\EmptyCondition\WhenNull;
use Yiisoft\Validator\Rule\Trait\SkipOnEmptyTrait;
use Yiisoft\Validator\Rule\Trait\WhenTrait;
use Yiisoft\Validator\RuleInterface;
use Yiisoft\Validator\SkipOnEmptyInterface;
use Yiisoft\Validator\WhenInterface;

final class Uppercase implements RuleInterface, SkipOnEmptyInterface, MessageValidationInterface, WhenInterface
{
    use SkipOnEmptyTrait;
    use WhenTrait;

    public function __construct(
        public readonly string $message = 'Строка должна состоять только из заглавных букв.',
        public readonly WhenMissing|NeverEmpty|WhenNull $skipOnEmpty = new NeverEmpty(),
        public Closure|null $when = null
    ) {
    }

    public function getName(): string
    {
        return 'uppercase';
    }

    public function getHandler(): string
    {
        return UppercaseHandler::class;
    }

    public function getMessage(): string
    {
        return $this->stringMessage() . " " . $this->message;
    }

    public function stringMessage(): string
    {
        return "Значение должно быть строкой.";
    }
}
