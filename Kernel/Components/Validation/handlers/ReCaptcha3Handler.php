<?php

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Google\ReCaptcha3 as ReCaptcha3Client;
use Kernel\Components\Validation\rules\ReCaptcha3;
use Kernel\Components\Validation\rules\Uppercase;
use RuntimeException;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class ReCaptcha3Handler implements RuleHandlerInterface
{
    public function __construct(private readonly ReCaptcha3Client $reCaptcha3)
    {
    }

    /**
     * @throws UnexpectedRuleException
     * @throws RuntimeException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof ReCaptcha3) {
            throw new UnexpectedRuleException(Uppercase::class, $rule);
        }

        if (!is_string($value) || !$this->reCaptcha3->isValid($value)) {
            return (new Result())->addError(
                $rule->getMessage(),
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        return new Result();
    }
}
