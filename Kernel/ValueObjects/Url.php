<?php

namespace Kernel\ValueObjects;

use Kernel\Components\Exception\Validation\ValidationException;
use ReflectionException;
use RuntimeException;
use Yiisoft\Validator\Rule\Url as UrlValidator;
use Yiisoft\Validator\Validator;

/**
 * @template-extends AbstractValueObject<string>
 */
final readonly class Url extends AbstractValueObject
{
    public string $url;

    public function __construct(mixed $value)
    {
        parent::__construct($value);
        /** @var string $value */
        $this->url = $value;
    }

    /**
     * @throws ReflectionException|ValidationException|RuntimeException
     */
    protected function validate(mixed $value): void
    {
        $rule = new UrlValidator();
        $result = (new Validator())->validate($value, $rule);
        if (!$result->isValid()) {
            throw new ValidationException($rule->getMessage());
        }
    }

    public function getValue(): string
    {
        return $this->url;
    }
}
