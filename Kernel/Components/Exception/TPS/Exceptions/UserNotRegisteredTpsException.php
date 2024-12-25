<?php

declare(strict_types=1);

namespace Kernel\Components\Exception\TPS\Exceptions;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Exception\TPS\BaseTpsException;
use Kernel\Components\Exception\TpsErrorType;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class UserNotRegisteredTpsException extends BaseTpsException
{
    public function __construct(
        string $message = "Bad credentials",
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $previous, $additionalData);
    }

    public function getTpsHttpStatusCode(): int
    {
        return HttpResponseCode::UnprocessableEntity->value;
    }

    public static function redefinedTpsCode(): int|null
    {
        return TpsErrorType::ERROR_BAD_CREDENTIALS->value;
    }

    public function getTpsCode(): int
    {
        return TpsErrorType::ERROR_USER_NOT_REGISTERED->value;
    }

    public function getErrorLevel(): ErrorLevel
    {
        return ErrorLevel::NOTICE;
    }
}
