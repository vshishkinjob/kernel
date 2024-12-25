<?php

namespace Kernel\ValueObjects;

use InvalidArgumentException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\Validation\rules\BIC as BICValidator;
use ReflectionException;
use RuntimeException;
use Yiisoft\Validator\Validator;

/**
 * @template-extends AbstractValueObject<string>
 */
final readonly class BIC extends AbstractValueObject
{
    public string $bic;

    public function __construct(mixed $value)
    {
        parent::__construct($value);
        /** @var string $value */
        $this->bic = $value;
    }

    /**
     * @throws ReflectionException|ValidationException|RuntimeException|InvalidArgumentException
     */
    protected function validate(mixed $value): void
    {
        $rule = new BICValidator();
        $result = (new Validator())->validate($value, $rule);
        if (!$result->isValid()) {
            throw new ValidationException($rule->getMessage());
        }
    }

    public function getValue(): string
    {
        return $this->bic;
    }
}
