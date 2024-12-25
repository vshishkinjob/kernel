<?php

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Validation\rules\Pagination;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class PaginationHandler implements RuleHandlerInterface
{
    /**
     * @throws UnexpectedRuleException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof Pagination) {
            throw new UnexpectedRuleException(Pagination::class, $rule);
        }

        if (!is_array($value) || !isset($value['limit']) || !isset($value['offset'])) {
            return (new Result())->addError($rule->getMessage(), [
                'attribute' => $context->getTranslatedAttribute(),
                'type' => get_debug_type($value),
            ]);
        }

        foreach ($value as $attribute => $item) {
            if (!in_array($attribute, ['limit', 'offset'], strict: true)) {
                return (new Result())->addError("Указанно некорректное поле $attribute", [
                    'attribute' => $context->getTranslatedAttribute(),
                    'type' => get_debug_type($value),
                ]);
            }
        }

        if (!is_int($value['limit']) || $value['limit'] <= 0 || $value['limit'] > $rule->maxInt) {
            return (new Result())->addError($rule->getMessage(), [
                'attribute' => $context->getTranslatedAttribute(),
                'type' => get_debug_type($value),
            ]);
        }

        if (!is_int($value['offset']) || $value['offset'] < 0 || $value['offset'] > $rule->maxInt) {
            return (new Result())->addError($rule->getMessage(), [
                'attribute' => $context->getTranslatedAttribute(),
                'type' => get_debug_type($value),
            ]);
        }

        return new Result();
    }
}
