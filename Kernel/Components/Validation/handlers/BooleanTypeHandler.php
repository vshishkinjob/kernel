<?php

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Validation\rules\BooleanType;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class BooleanTypeHandler implements RuleHandlerInterface
{
    /**
     * @throws UnexpectedRuleException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof BooleanType) {
            throw new UnexpectedRuleException(BooleanType::class, $rule);
        }

        $result = new Result();

        if (!is_bool($value)) {
            $result->addError($rule->message, ['attribute' => $context->getTranslatedAttribute()]);
        }

        return $result;
    }
}
