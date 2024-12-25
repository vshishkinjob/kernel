<?php

namespace Kernel\ValueObjects;

use Kernel\Components\Exception\Validation\ValidationException;
use ReflectionException;
use RuntimeException;
use Yiisoft\Validator\Rule\Email as EmailValidator;
use Yiisoft\Validator\Validator;

/**
 * @template-extends AbstractValueObject<string>
 */
final readonly class Email extends AbstractValueObject
{
    public string $email;

    public function __construct(mixed $value)
    {
        parent::__construct($value);
        /** @var string $value */
        $this->email = $value;
    }

    /**
     * @throws ReflectionException|ValidationException|RuntimeException
     */
    protected function validate(mixed $value): void
    {
        $rule = new EmailValidator();
        $result = (new Validator())->validate($value, $rule);
        if (!$result->isValid()) {
            throw new ValidationException($rule->getMessage());
        }
    }

    public function getValue(): string
    {
        return $this->email;
    }
}
