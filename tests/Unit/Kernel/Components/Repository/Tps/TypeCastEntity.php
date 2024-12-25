<?php

namespace Unit\Kernel\Components\Repository\Tps;

use DateTime;
use Kernel\Components\Repository\Components\BaseEntity;
use Kernel\Components\Repository\Components\Tps\Annotation\TpsColumn;
use Kernel\Enums\User\SubjectType;

class TypeCastEntity extends BaseEntity
{
    public function __construct(
        #[TpsColumn(name: 'dateField', type: DateTime::class)]
        private DateTime $dateField,
        private string $stringField,
        #[TpsColumn(name: "single_name")]
        private int $singleName,
        #[TpsColumn(name: ["multiple_name", "other_name"])]
        private array $multipleName,
        #[TpsColumn(name: 'enumType', type: SubjectType::class)]
        private SubjectType $enumType
    ) {
    }

    public function getDateField(): DateTime
    {
        return $this->dateField;
    }

    public function getStringField(): string
    {
        return $this->stringField;
    }

    public function getSingleName(): int
    {
        return $this->singleName;
    }

    public function getMultipleName(): array
    {
        return $this->multipleName;
    }

    public function getEnumType(): SubjectType
    {
        return $this->enumType;
    }
}
