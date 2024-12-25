<?php

declare(strict_types=1);

namespace Kernel\Components\Exception;

enum ErrorLevel
{
    case INFO;
    case NOTICE;
    case WARNING;
    case ERROR;
    case CRITICAL;
    case ALERT;
    case EMERGENCY;

    public static function isInErrorList(ErrorLevel $level): bool
    {
        $array = [
            self::ERROR,
            self::CRITICAL,
            self::ALERT,
            self::EMERGENCY
        ];
        return in_array($level, $array, true);
    }
}
