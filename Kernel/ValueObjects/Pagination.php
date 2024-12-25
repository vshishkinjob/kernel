<?php

namespace Kernel\ValueObjects;

use DivisionByZeroError;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\Validation\rules\Pagination as PaginationValidator;
use ReflectionException;
use Yiisoft\Validator\Validator;

/**
 * @template-extends AbstractValueObject<array{offset: int, limit: int}>
 */
final readonly class Pagination extends AbstractValueObject
{
    public int $offset;
    public int $limit;

    public function __construct(mixed $value)
    {
        parent::__construct($value);
        /** @var array{limit: int, offset: int} $value */
        $this->offset = $value['offset'];
        $this->limit = $value['limit'];
    }

    /**
     * @throws ReflectionException|ValidationException
     */
    protected function validate(mixed $value): void
    {
        $rule = new PaginationValidator();
        $result = (new Validator())->validate($value, $rule);
        if (!$result->isValid()) {
            throw new ValidationException($rule->getMessage());
        }
    }

    /**
     * @throws DivisionByZeroError
     */
    public function getPage(): int
    {
        return (int)(floor($this->offset / $this->limit) + 1);
    }

    public function getValue(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit
        ];
    }
}
