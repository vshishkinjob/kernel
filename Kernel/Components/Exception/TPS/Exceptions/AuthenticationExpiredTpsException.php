<?php

declare(strict_types=1);

namespace Kernel\Components\Exception\TPS\Exceptions;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Exception\TPS\BaseTpsException;
use Kernel\Components\Exception\TpsErrorType;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class AuthenticationExpiredTpsException extends BaseTpsException
{
    public function __construct(
        string $message = "Authentication expired",
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $previous, $additionalData);
    }

    public function getTpsHttpStatusCode(): int
    {
        return HttpResponseCode::Unauthorized->value;
    }

    public function getTpsCode(): int
    {
        return TpsErrorType::ERROR_AUTH_KEY_EXPIRED->value;
    }

    public function getErrorLevel(): ErrorLevel
    {
        return ErrorLevel::NOTICE;
    }
}
