<?php

namespace Kernel\Components\Validation\handlers;

use Kernel\Components\Validation\rules\Uppercase;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class UppercaseHandler implements RuleHandlerInterface
{
	/**
	 * @throws UnexpectedRuleException
	 */
	public function validate(mixed $value, object $rule, ValidationContext $context): Result
	{
		if (!$rule instanceof Uppercase) {
			throw new UnexpectedRuleException(Uppercase::class, $rule);
		}

		$result = new Result();

		if (!is_string($value)) {
			return $result->addError($rule->stringMessage(), ['attribute' => $context->getTranslatedAttribute()]);
		}

		if ($value !== mb_strtoupper($value)) {
			$result->addError($rule->getMessage(), ['attribute' => $context->getTranslatedAttribute()]);
		}

		return $result;
	}
}
