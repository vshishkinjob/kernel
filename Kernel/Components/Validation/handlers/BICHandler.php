<?php

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Validation\rules\BIC;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class BICHandler implements RuleHandlerInterface
{
    /**
     * @throws UnexpectedRuleException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof BIC) {
            throw new UnexpectedRuleException(BIC::class, $rule);
        }

        if (!is_string($value)) {
            return (new Result())->addError(
                $rule->stringMessage(),
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        if (!$this->isValidBic($value)) {
            return (new Result())->addError($rule->getMessage(), ['attribute' => $context->getTranslatedAttribute()]);
        }

        return new Result();
    }


    private function isValidBic(string $value): bool
    {
        return preg_match("/^[A-Z0-9]{8}$/", $value) === 1;
    }
}
