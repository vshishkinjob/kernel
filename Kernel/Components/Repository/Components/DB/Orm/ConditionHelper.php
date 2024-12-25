<?php

namespace Kernel\Components\Repository\Components\DB\Orm;

use DateTime;
use Exception;
use Kernel\Components\Exception\Validation\ValidationException;

class ConditionHelper
{
    /**
     * @param array<string, mixed> $data
     * @return array<string, array<string, mixed>>
     * @throws Exception
     */
    public static function getDateTimeCondition(
        array $data,
        string $dateFromKey,
        string $dateToKey,
        string $propertyName
    ): array {
        $dateTimeCondition = [];
        if (isset($data[$dateFromKey]) && isset($data[$dateToKey])) {
            if (!is_string($data[$dateToKey])) {
                throw new ValidationException('Should be string', 500);
            }
            $dateToFilter = new DateTime($data[$dateToKey]);
            $dateToFilter->modify('+1 day');
            $dateTimeCondition[$propertyName] = [
                'between' => [
                    $data[$dateFromKey],
                    $dateToFilter->format('Y-m-d')
                ]
            ];
            return $dateTimeCondition;
        } elseif (isset($data[$dateToKey])) {
            $dateTimeCondition[$propertyName] = ['<=' => $data[$dateToKey]];
            return $dateTimeCondition;
        }
        $dateTimeCondition[$propertyName] = ['>=' => $data[$dateFromKey]];
        return $dateTimeCondition;
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, array{"=": mixed}>
     */
    public static function getEqualsCondition(
        array $data,
        string $propertyName,
        string $filterName
    ): array {
        $condition = [];

        if (isset($data[$filterName])) {
            $condition[$propertyName] = ['=' => $data[$filterName]];
        }

        return $condition;
    }
}
