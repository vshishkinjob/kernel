<?php

namespace Kernel\Components\Validation\rules;

use Closure;
use Kernel\Components\Validation\handlers\IntegerTypeHandler;
use Kernel\Components\Validation\MessageValidationInterface;
use Kernel\Enums\PostgresqlLimitation;
use Yiisoft\Validator\EmptyCondition\NeverEmpty;
use Yiisoft\Validator\EmptyCondition\WhenMissing;
use Yiisoft\Validator\EmptyCondition\WhenNull;
use Yiisoft\Validator\Rule\Trait\SkipOnEmptyTrait;
use Yiisoft\Validator\Rule\Trait\WhenTrait;
use Yiisoft\Validator\RuleInterface;
use Yiisoft\Validator\SkipOnEmptyInterface;
use Yiisoft\Validator\WhenInterface;

final class IntegerType implements RuleInterface, SkipOnEmptyInterface, WhenInterface, MessageValidationInterface
{
    use SkipOnEmptyTrait;
    use WhenTrait;

    public function __construct(
        public readonly ?int $min = null,
        public readonly ?int $max = PostgresqlLimitation::INT_MAX_VALUE->value,
        public readonly string $message = 'Значение должно быть целым числом.',
        public readonly WhenMissing|NeverEmpty|WhenNull $skipOnEmpty = new NeverEmpty(),
        public readonly ?Closure $when = null
    ) {
    }

    public function getName(): string
    {
        return 'integerType';
    }

    public function getHandler(): string
    {
        return IntegerTypeHandler::class;
    }

    public function getMessage(): string
    {
        $message = $this->message;

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
}
