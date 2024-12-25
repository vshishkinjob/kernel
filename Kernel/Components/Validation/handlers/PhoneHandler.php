<?php

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Validation\rules\Phone;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class PhoneHandler implements RuleHandlerInterface
{
    /**
     * @throws UnexpectedRuleException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof Phone) {
            throw new UnexpectedRuleException(Phone::class, $rule);
        }

        if (!is_string($value)) {
            return (new Result())->addError(
                $rule->stringMessage(),
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        if (!$this->isValidPhone($value, $rule)) {
            return (new Result())->addError($rule->getMessage(), ['attribute' => $context->getTranslatedAttribute()]);
        }

        return new Result();
    }

    private function isValidPhone(string $value, Phone $rule): bool
    {
        return preg_match($rule->regEx, $value) === 1;
    }
}
