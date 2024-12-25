<?php

declare(strict_types=1);

namespace Kernel\Components\Validation\rules;

use Closure;
use InvalidArgumentException;
use Kernel\Components\Validation\handlers\CallbackHandler;
use Kernel\Components\Validation\MessageValidationInterface;
use ReflectionObject;
use Yiisoft\Validator\AfterInitAttributeEventInterface;
use Yiisoft\Validator\Rule\Trait\SkipOnEmptyTrait;
use Yiisoft\Validator\Rule\Trait\SkipOnErrorTrait;
use Yiisoft\Validator\Rule\Trait\WhenTrait;
use Yiisoft\Validator\RuleWithOptionsInterface;
use Yiisoft\Validator\SkipOnEmptyInterface;
use Yiisoft\Validator\SkipOnErrorInterface;
use Yiisoft\Validator\WhenInterface;

final class Callback implements
	RuleWithOptionsInterface,
	SkipOnErrorInterface,
	WhenInterface,
	SkipOnEmptyInterface,
	AfterInitAttributeEventInterface,
	MessageValidationInterface
{
	use SkipOnEmptyTrait;
	use SkipOnErrorTrait;
	use WhenTrait;

	/**
     * @phan-suppress PhanImpossibleTypeComparison
	 * @throws InvalidArgumentException
	 */
	public function __construct(
		private string $message,
		private mixed $callback = null,
		private string|null $method = null,
		private mixed $skipOnEmpty = null,
		private bool $skipOnError = false,
		private Closure|null $when = null
	) {
        if ($this->callback !== null && !is_callable($this->callback)) {
            throw new InvalidArgumentException('"$callback" should be callable!');
        }

		if ($this->callback === null && $this->method === null) {
			throw new InvalidArgumentException('Either "$callback" or "$method" must be specified.');
		}

		if ($this->callback !== null && $this->method !== null) {
			throw new InvalidArgumentException('"$callback" and "$method" are mutually exclusive.');
		}
	}

	public function getName(): string
	{
		return 'callback';
	}

	/**
	 * Get the callable that performs validation.
	 *
	 * @return callable|null The callable that performs validation.
	 *
	 * @see $callback
	 */
	public function getCallback(): callable|null
	{
        /** @var callable|null $callback */
		$callback = $this->callback;
        return $callback;
	}

	/**
	 * Get a name of a validated object method that performs the validation.
	 *
	 * @return string|null Name of a method that performs the validation.
	 *
	 * @see $method
	 */
	public function getMethod(): string|null
	{
		return $this->method;
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function afterInitAttribute(object $object): void
	{
		if ($this->method === null) {
			return;
		}

		$method = $this->method;

		$reflection = new ReflectionObject($object);
		if (!$reflection->hasMethod($method)) {
			throw new InvalidArgumentException(
				sprintf(
					'Method "%s" does not exist in class "%s".',
					$method,
					$object::class,
				)
			);
		}

		/** @psalm-suppress MixedMethodCall */
		$this->callback = Closure::bind(fn (mixed ...$args): mixed => $object->{$method}(...$args), $object, $object);
	}

    /**
     * @return array<string, mixed>
     */
	public function getOptions(): array
	{
		return [
			'method' => $this->method,
			'skipOnEmpty' => $this->getSkipOnEmptyOption(),
			'skipOnError' => $this->skipOnError,
		];
	}

	public function getHandler(): string
	{
		return CallbackHandler::class;
	}

	public function getMessage(): string
	{
		return $this->message;
	}
}
