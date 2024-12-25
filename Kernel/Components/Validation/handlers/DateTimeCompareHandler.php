<?php

namespace Kernel\Components\Validation\handlers;

use DateTime;
use Exception;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\Helpers\DateHelper;
use Kernel\Components\Validation\rules\DateTimeCompare;
use Kernel\Enums\CompareOperator;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class DateTimeCompareHandler implements RuleHandlerInterface
{
    /**
     * @throws ValidationException
     * @throws Exception
     * @throws UnexpectedRuleException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof DateTimeCompare) {
            throw new UnexpectedRuleException(DateTimeCompare::class, $rule);
        }

        $result = new Result();
        $firstOperand = $context->getGlobalDataSet()->getAttributeValue($rule->firstAttributeName);
        $result = $this->isValidDate($firstOperand, $rule->firstAttributeName, $result);
        $secondOperand = $context->getGlobalDataSet()->getAttributeValue($rule->secondAttributeName);
        $result = $this->isValidDate($secondOperand, $rule->secondAttributeName, $result);
        if (!$result->isValid()) {
            return $result;
        }
        /**
         * @var string $firstOperand
         * @var string $secondOperand
         */
        $firstDate = new DateTime($firstOperand);
        $secondDate = new DateTime($secondOperand);

        if (!DateHelper::compareDates($firstDate, $secondDate, $rule->operator)) {
            $result->addError($rule->getMessage());
        }

        if (
            $rule->maxInterval !== null
            && !DateHelper::compareInterval($firstDate, $secondDate, $rule->maxInterval, CompareOperator::LESS_OR_EQUAL)
        ) {
            $result->addError(
                "Разница между датами {$rule->firstAttributeName} и {$rule->secondAttributeName} должна быть не более - "
                . DateHelper::getIntervalInWords($rule->maxInterval)
            );
        }
        return $result;
    }

    private function isValidDate(mixed $value, string $attribute, Result $result): Result
    {
        if (!is_string($value) || strtotime($value) === false) {
            $result->addError("$attribute не является допустимой датой!");
        }
        return $result;
    }
}
