<?php

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Validation\rules\Base64;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class Base64Handler implements RuleHandlerInterface
{
    private const MODULE_NUMBER = 4;

    /**
     * @throws UnexpectedRuleException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof Base64) {
            throw new UnexpectedRuleException(Base64::class, $rule);
        }

        if (!is_string($value)) {
            return (new Result())->addError(
                $rule->stringMessage(),
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        if (!$this->isValidBase64($value)) {
            return (new Result())->addError($rule->message, ['attribute' => $context->getTranslatedAttribute()]);
        }

        return new Result();
    }

    private function isValidBase64(string $value): bool
    {
        if (!preg_match('#^[A-Za-z0-9+/\n\r]+={0,2}$#', $value)) {
            return false;
        }

        return strlen($value) % self::MODULE_NUMBER === 0;
    }
}
