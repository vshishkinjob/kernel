<?php

namespace Kernel\ValueObjects;

use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\Validation\rules\Password as PasswordValidator;
use ReflectionException;
use RuntimeException;
use Yiisoft\Validator\Validator;

/**
 * @template-extends AbstractValueObject<string>
 */
final readonly class Password extends AbstractValueObject
{
    public string $password;

    public function __construct(mixed $value)
    {
        parent::__construct($value);
        /** @var string $value */
        $this->password = $value;
    }

    /**
     * @throws ReflectionException|ValidationException|RuntimeException
     */
    protected function validate(mixed $value): void
    {
        $rule = new PasswordValidator();
        $result = (new Validator())->validate($value, $rule);
        if (!$result->isValid()) {
            throw new ValidationException($rule->getMessage());
        }
    }

    public function getValue(): string
    {
        return $this->password;
    }
}
