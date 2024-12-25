<?php

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Validation\rules\Password;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class PasswordHandler implements RuleHandlerInterface
{
    /**
     * @throws UnexpectedRuleException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof Password) {
            throw new UnexpectedRuleException(Password::class, $rule);
        }
        if (!is_string($value)) {
            return (new Result())->addError(
                $rule->stringMessage(),
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        $result = new Result();
        if (!preg_match($rule->regEx, $value)) {
            $result->addError($rule->getMessage(), ['attribute' => $context->getTranslatedAttribute()]);
        }
        return $result;
    }
}
