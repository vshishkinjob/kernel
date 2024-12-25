<?php

declare(strict_types=1);

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Validation\rules\IndexedArray;
use RuntimeException;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

use function is_int;

/**
 * A handler for {@see IndexedArray} rule. Validates each element of an iterable using a set of rules.
 */
final class IndexArrayHandler implements RuleHandlerInterface
{
    /**
     * @throws UnexpectedRuleException|RuntimeException
     */
    public function validate(mixed $value, object $rule, ValidationContext $context): Result
    {
        if (!$rule instanceof IndexedArray) {
            throw new UnexpectedRuleException(IndexedArray::class, $rule);
        }

        /** @var mixed $value */
        $value = $context->getParameter(ValidationContext::PARAMETER_VALUE_AS_ARRAY) ?? $value;
        if (!is_iterable($value)) {
            return (new Result())->addError($rule->getIncorrectInputMessage(), [
                'attribute' => $context->getTranslatedAttribute(),
                'type' => get_debug_type($value),
            ]);
        }

        if (!$rule->canBeEmpty && empty($value)) {
            return (new Result())->addError("Array is not allowed to be empty!", [
                'attribute' => $context->getTranslatedAttribute(),
                'type' => get_debug_type($value),
            ]);
        }

        $rules = $rule->getRules();
        $result = new Result();

        /** @var mixed $item */
        foreach ($value as $index => $item) {
            if (!is_int($index)) {
                return (new Result())->addError($rule->getIncorrectInputKeyMessage(), [
                    'attribute' => $context->getTranslatedAttribute(),
                    'type' => get_debug_type($value),
                ]);
            }

            $itemResult = $context->validate($item, $rules);
            if ($itemResult->isValid()) {
                continue;
            }

            foreach ($itemResult->getErrors() as $error) {
                $result->addError(
                    $error->getMessage(),
                    $error->getParameters(),
                    $error->getValuePath() === [] ? [$index] : [$index, ...$error->getValuePath()],
                );
            }
        }

        return $result;
    }
}
