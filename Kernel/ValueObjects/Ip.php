<?php

namespace Kernel\ValueObjects;

use InvalidArgumentException;
use Kernel\Components\Exception\Validation\ValidationException;
use ReflectionException;
use RuntimeException;
use Yiisoft\Validator\Rule\Ip as IpValidator;
use Yiisoft\Validator\Validator;

/**
 * @template-extends AbstractValueObject<string>
 */
final readonly class Ip extends AbstractValueObject
{
    public string $ip;

    public function __construct(mixed $value)
    {
        parent::__construct($value);
        /** @var string $value */
        $this->ip = $value;
    }

    /**
     * @throws ReflectionException|ValidationException|RuntimeException|InvalidArgumentException
     */
    protected function validate(mixed $value): void
    {
        $rule = new IpValidator(allowSubnet: true);
        $result = (new Validator())->validate($value, $rule);
        if (!$result->isValid()) {
            throw new ValidationException($rule->getMessage());
        }
    }

    public function getValue(): string
    {
        return $this->ip;
    }
}
