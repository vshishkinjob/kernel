<?php

declare(strict_types=1);

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Validation\rules\NumberLength;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class NumberLengthHandler implements RuleHandlerInterface
{
    /**
     * @throws UnexpectedRuleException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof NumberLength) {
            throw new UnexpectedRuleException(NumberLength::class, $rule);
        }

        if (!is_numeric($value)) {
            return (new Result())->addError($rule->message, ['attribute' => $context->getTranslatedAttribute()]);
        }

        $length = strlen((string)$value);

        $result = new Result();

        if ($rule->exactly !== null && $length !== $rule->exactly) {
            $result->addError($rule->getExactlyMessage(), ['attribute' => $context->getTranslatedAttribute()]);
        }

        if ($rule->min !== null && $length < $rule->min) {
            $result->addError($rule->getMinMessage(), ['attribute' => $context->getTranslatedAttribute()]);
        }

        if ($rule->max !== null && $length > $rule->max) {
            $result->addError($rule->getMaxMessage(), ['attribute' => $context->getTranslatedAttribute()]);
        }

        return $result;
    }
}
