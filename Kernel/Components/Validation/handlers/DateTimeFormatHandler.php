<?php

namespace Kernel\Components\Validation\handlers;

use DateTime;
use Exception;
use Kernel\Components\Validation\rules\DateTimeFormat;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class DateTimeFormatHandler implements RuleHandlerInterface
{
    /**
     * @throws UnexpectedRuleException
     * @throws Exception
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof DateTimeFormat) {
            throw new UnexpectedRuleException(DateTimeFormat::class, $rule);
        }

        if (!is_string($value)) {
            return (new Result())->addError(
                $rule->stringMessage(),
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        if (!$this->isValidDate($value, $rule)) {
            return (new Result())->addError(
                $rule->getMessage(),
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        if ($rule->lessThanCurrentTime && $this->isMoreThanCurrentDate($value)) {
            return (new Result())->addError(
                "Дата не может быть больше текущего дня!",
                ['attribute' => $context->getTranslatedAttribute()]
            );
        }

        return new Result();
    }

    private function isValidDate(string $value, DateTimeFormat $rule): bool
    {
        if ($rule->format === null) {
            return strtotime($value) !== false;
        }

        $dateTime = DateTime::createFromFormat($rule->format, $value);
        return $dateTime && $dateTime->format($rule->format) === $value;
    }

    /** @phan-suppress PhanPluginComparisonObjectOrdering
     * @throws Exception
     */
    private function isMoreThanCurrentDate(string $value): bool
    {
        $current = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d") . " 23:59:59");
        return new DateTime($value) > $current;
    }
}
