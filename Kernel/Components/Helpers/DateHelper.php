<?php

declare(strict_types=1);

namespace Kernel\Components\Helpers;

use DateInterval;
use DateTime;
use Exception;
use Kernel\Components\Exception\App\NotValidEntityException;
use Kernel\Enums\CompareOperator;

class DateHelper
{
    /**
     * Returns true if comparison of two dates is true according to operator
     * @phan-suppress PhanPluginComparisonObjectOrdering
     * @phan-suppress PhanPluginComparisonObjectEqualityNotStrict
     * @return bool
     */
    public static function compareDates(DateTime $firstDate, DateTime $secondDate, CompareOperator $operator): bool
    {
        return match ($operator) {
            CompareOperator::MORE           => $firstDate > $secondDate,
            CompareOperator::MORE_OR_EQUAL  => $firstDate >= $secondDate,
            CompareOperator::LESS           => $firstDate < $secondDate,
            CompareOperator::LESS_OR_EQUAL  => $firstDate <= $secondDate,
            CompareOperator::EQUAL          => $firstDate == $secondDate,
            CompareOperator::NOT_EQUAL      => $firstDate != $secondDate
        };
    }

    /**
     * @phan-suppress PhanImpossibleTypeComparison
     * @throws Exception|NotValidEntityException
     */
    public static function compareInterval(
        DateTime $firstOperand,
        DateTime $secondOperand,
        DateInterval $compareInterval,
        CompareOperator $operator
    ): bool {
        $intervalInSeconds = self::convertIntervalToSeconds($firstOperand->diff($secondOperand));
        $compareIntervalInSeconds = self::convertIntervalToSeconds($compareInterval);

        return match ($operator) {
            CompareOperator::MORE           => $intervalInSeconds > $compareIntervalInSeconds,
            CompareOperator::MORE_OR_EQUAL  => $intervalInSeconds >= $compareIntervalInSeconds,
            CompareOperator::LESS           => $intervalInSeconds < $compareIntervalInSeconds,
            CompareOperator::LESS_OR_EQUAL  => $intervalInSeconds <= $compareIntervalInSeconds,
            CompareOperator::EQUAL          => $intervalInSeconds == $compareIntervalInSeconds,
            CompareOperator::NOT_EQUAL      => $intervalInSeconds != $compareIntervalInSeconds
        };
    }

    public static function convertIntervalToSeconds(DateInterval $interval): int
    {
        $minute = 60;
        $hour = 60 * $minute;
        $day = 24 * $hour;
        $daysTime = $interval->days !== false
            ? ($interval->days * $day)
            : ($interval->y * 365 * $day + $interval->m * 31 * $day + $interval->d * $day);
        return $daysTime + $interval->h * $hour + $interval->i * $minute + $interval->s;
    }

    public static function getIntervalInWords(DateInterval $interval): string
    {
        $result = '';
        if ($interval->y !== 0) {
            $result .= "$interval->y лет ";
        }
        if ($interval->m !== 0) {
            $result .= "$interval->m месяцев ";
        }
        if ($interval->d !== 0) {
            $result .= "$interval->d дней ";
        }
        if ($interval->h !== 0) {
            $result .= "$interval->h часов ";
        }
        if ($interval->i !== 0) {
            $result .= "$interval->i минут ";
        }
        if ($interval->s !== 0) {
            $result .= "$interval->s секунд ";
        }
        return trim($result);
    }
}
