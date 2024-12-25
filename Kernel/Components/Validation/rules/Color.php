<?php

namespace Kernel\Components\Validation\rules;

use Closure;
use Kernel\Components\Validation\handlers\ColorHandler;
use Kernel\Components\Validation\MessageValidationInterface;
use Yiisoft\Validator\EmptyCondition\NeverEmpty;
use Yiisoft\Validator\EmptyCondition\WhenMissing;
use Yiisoft\Validator\EmptyCondition\WhenNull;
use Yiisoft\Validator\Rule\Trait\SkipOnEmptyTrait;
use Yiisoft\Validator\Rule\Trait\WhenTrait;
use Yiisoft\Validator\RuleInterface;
use Yiisoft\Validator\SkipOnEmptyInterface;
use Yiisoft\Validator\WhenInterface;

final class Color implements RuleInterface, SkipOnEmptyInterface, MessageValidationInterface, WhenInterface
{
    use SkipOnEmptyTrait;
    use WhenTrait;

    /** if $hex and $rgb both false or true - will check for both format*/
    public function __construct(
        public readonly bool $hex = false,
        public readonly bool $rgb = false,
        public readonly string $message = 'Значение должно быть цветом.',
        public readonly WhenMissing|NeverEmpty|WhenNull $skipOnEmpty = new NeverEmpty(),
        public Closure|null $when = null
    ) {
    }

    public function getName(): string
    {
        return 'color';
    }

    public function getHandler(): string
    {
        return ColorHandler::class;
    }

    public function getMessage(): string
    {
        if (!$this->hex xor $this->rgb) {
            return $this->message . " Формат цвета должен быть RGB или HEX";
        }
        if ($this->hex) {
            return $this->message . " Формат цвета должен быть HEX";
        }
        return $this->message . " Формат цвета должен быть RGB";
    }

    public function stringMessage(): string
    {
        return 'Параметр должен быть строкой.';
    }
}
