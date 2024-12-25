<?php

declare(strict_types=1);

namespace Kernel\Components\Validation\handlers;

use InvalidArgumentException;
use Kernel\Components\Validation\rules\Callback;
use Yiisoft\Validator\Exception\InvalidCallbackReturnTypeException;
use Yiisoft\Validator\Exception\UnexpectedRuleException;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\RuleHandlerInterface;
use Yiisoft\Validator\ValidationContext;

final class CallbackHandler implements RuleHandlerInterface
{
	/**
	 * @throws InvalidCallbackReturnTypeException
	 * @throws UnexpectedRuleException
	 * @throws InvalidArgumentException
	 */
	public function validate(mixed $value, object $rule, ValidationContext $context): Result
	{
		if (!$rule instanceof Callback) {
			throw new UnexpectedRuleException(Callback::class, $rule);
		}

		$callback = $rule->getCallback();
		if ($callback === null) {
			throw new InvalidArgumentException('Using method outside of attribute scope is prohibited.');
		}

		$result = $callback($value, $rule, $context);
		if (!$result instanceof Result) {
			throw new InvalidCallbackReturnTypeException($result);
		}

		return $result;
	}
}
