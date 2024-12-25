<?php

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Validation\rules\FloatType;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class FloatTypeHandler implements RuleHandlerInterface
{
    /**
     * @throws UnexpectedRuleException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof FloatType) {
            throw new UnexpectedRuleException(FloatType::class, $rule);
        }

        $result = new Result();

        if (!$this->isValid($value, $rule)) {
            $result->addError($rule->getMessage(), ['attribute' => $context->getTranslatedAttribute()]);
        }

        if ($rule->min !== null && $value < $rule->min) {
            $result->addError($rule->getMinMessage(), ['attribute' => $context->getTranslatedAttribute()]);
        }

        if ($rule->max !== null && $value > $rule->max) {
            $result->addError($rule->getMaxMessage(), ['attribute' => $context->getTranslatedAttribute()]);
        }

        return $result;
    }

    private function isValid(mixed $value, FloatType $rule): bool
    {
        if ($rule->withInt) {
            return is_float($value) || is_int($value);
        }

        return is_float($value);
    }
}
