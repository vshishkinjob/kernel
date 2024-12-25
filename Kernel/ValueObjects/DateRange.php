<?php

namespace Kernel\ValueObjects;

use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\Validation\rules\DateRange as DateRangeValidator;
use ReflectionException;
use Yiisoft\Validator\Validator;

/**
 * @template-extends AbstractValueObject<array{dateFrom: string|null, dateTo:string|null}>
 */
final readonly class DateRange extends AbstractValueObject
{
    public ?string $dateFrom;
    public ?string $dateTo;

    public function __construct(mixed $value)
    {
        parent::__construct($value);
        /** @var  array{dateFrom?: string, dateTo?: string} $value */
        $this->dateFrom = $value['dateFrom'] ?? null;
        $this->dateTo = $value['dateTo'] ?? null;
    }

    /**
     * @throws ReflectionException|ValidationException
     */
    protected function validate(mixed $value): void
    {
        $rule = new DateRangeValidator(lessThanCurrentTime: false);
        $result = (new Validator())->validate($value, $rule);
        if (!$result->isValid()) {
            throw new ValidationException($rule->getMessage());
        }
    }

    public function getValue(): array
    {
        return [
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo
        ];
    }
}
