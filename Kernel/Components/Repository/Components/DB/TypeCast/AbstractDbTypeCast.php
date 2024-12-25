<?php

declare(strict_types=1);

namespace Kernel\Components\Repository\Components\DB\TypeCast;

use Cycle\ORM\Parser\CastableInterface;
use Cycle\ORM\Parser\UncastableInterface;

abstract class AbstractDbTypeCast implements CastableInterface, UncastableInterface
{
    /** @var list<string> $columns */
    private array $columns = [];

    /**
     * @param array<non-empty-string, mixed> $rules
     * @return array<non-empty-string, mixed>
     */
    public function setRules(array $rules): array
    {
        foreach ($rules as $key => $rule) {
            if ($rule === $this::class) {
                unset($rules[$key]);
                $this->columns[] = $key;
            }
        }
        return $rules;
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function cast(array $data): array
    {
        foreach ($this->columns as $column) {
            if (isset($data[$column])) {
                $data[$column] = $this->convertToApplicationFormat($data[$column]);
            }
        }
        return $data;
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function uncast(array $data): array
    {
        foreach ($this->columns as $column) {
            if (isset($data[$column])) {
                $data[$column] = $this->convertToDbFormat($data[$column]);
            }
        }
        return $data;
    }

    abstract protected function convertToApplicationFormat(mixed $data): mixed;

    abstract protected function convertToDbFormat(mixed $data): mixed;
}
