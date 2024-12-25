<?php

namespace Kernel\Components\Validation\handlers;

use DateTime;
use Exception;
use Kernel\Components\Helpers\DateHelper;
use Kernel\Components\Validation\rules\DateRange;
use Kernel\Components\Validation\rules\DateTimeFormat;
use Kernel\Enums\CompareOperator;
use ReflectionException;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;
use Yiisoft\Validator\Validator;

final class DateRangeHandler implements RuleHandlerInterface
{
    /**
     * @throws UnexpectedRuleException
     * @throws ReflectionException
     * @throws Exception
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof DateRange) {
            throw new UnexpectedRuleException(DateRange::class, $rule);
        }

        if (!is_array($value) || !$this->hasRequireFields($value, $rule)) {
            return (new Result())->addError($rule->getMessage(), [
                'attribute' => $context->getTranslatedAttribute()
            ]);
        }

        /** @var array{dateFrom?: mixed, dateTo?: mixed} $value */
        $result = $this->validateDates($value, $rule);
        if (!$result->isValid()) {
            return $result;
        }

        if (isset($value['dateFrom'], $value['dateTo'])) {
            /** @var array{dateFrom: string, dateTo: string} $value */
            return $this->validateDatesRange($value, $rule, $context);
        }

        return new Result();
    }

    /**
     * @param array{dateFrom?: mixed, dateTo?: mixed, ...} $dates
     * @throws ReflectionException
     */
    private function validateDates(
        array $dates,
        DateRange $rule
    ): Result {
        $result = new Result();
        foreach ($dates as $attribute => $date) {
            if (!in_array($attribute, ['dateFrom', 'dateTo'], strict: true)) {
                $result->addError("В временном диапазоне указано некорректное поле $attribute!", [
                    'attribute' => $attribute
                ]);
            }
            $validation = (new Validator())->validate(
                $date,
                new DateTimeFormat(
                    format: $rule->format,
                    lessThanCurrentTime: $rule->lessThanCurrentTime
                )
            );
            if (!$validation->isValid()) {
                foreach ($validation->getErrors() as $error) {
                    $result->addError($error->getMessage(), [
                        'attribute' => $attribute
                    ]);
                }
            }
        }
        return $result;
    }

    /**
     * @param array{dateFrom: string, dateTo: string} $value
     * @throws Exception
     */
    private function validateDatesRange(array $value, DateRange $rule, ValidationContext $context): Result
    {
        $result = new Result();
        $dateFrom = new DateTime($value['dateFrom']);
        $dateTo = new DateTime($value['dateTo']);

        if (!DateHelper::compareDates($dateFrom, $dateTo, CompareOperator::LESS_OR_EQUAL)) {
            $result->addError("dateFrom должно быть больше или равно dateTo!", [
                'attribute' => $context->getTranslatedAttribute()
            ]);
        }

        if (
            $rule->maxInterval !== null
            && !DateHelper::compareInterval($dateFrom, $dateTo, $rule->maxInterval, CompareOperator::LESS_OR_EQUAL)
        ) {
            $result->addError($rule->getMaxPeriodMessage(), [
                'attribute' => $context->getTranslatedAttribute()
            ]);
        }

        return $result;
    }

    private function hasRequireFields(array $value, DateRange $rule): bool
    {
        if ($rule->isDateFromRequired && !isset($value['dateFrom'])) {
            return false;
        }

        if ($rule->isDateToRequired && !isset($value['dateTo'])) {
            return false;
        }

        return isset($value['dateFrom']) || isset($value['dateTo']);
    }
}
