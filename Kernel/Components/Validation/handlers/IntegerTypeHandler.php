<?php

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Validation\rules\IntegerType;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class IntegerTypeHandler implements RuleHandlerInterface
{
    /**
     * @throws UnexpectedRuleException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof IntegerType) {
            throw new UnexpectedRuleException(IntegerType::class, $rule);
        }

        $result = new Result();

        if (!is_int($value)) {
            return $result->addError($rule->message, ['attribute' => $context->getTranslatedAttribute()]);
        }

        if ($rule->min !== null && $value < $rule->min) {
            $result->addError($rule->getMinMessage(), ['attribute' => $context->getTranslatedAttribute()]);
        }

        if ($rule->max !== null && $value > $rule->max) {
            $result->addError($rule->getMaxMessage(), ['attribute' => $context->getTranslatedAttribute()]);
        }

        return $result;
    }
}
