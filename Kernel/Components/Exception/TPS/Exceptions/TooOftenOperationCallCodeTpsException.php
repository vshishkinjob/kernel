<?php

namespace Kernel\Components\Exception\TPS\Exceptions;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Exception\TPS\BaseTpsException;
use Kernel\Components\Exception\TpsErrorType;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class TooOftenOperationCallCodeTpsException extends BaseTpsException
{
    public function __construct(
        string $message = "Too often operation call code",
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $previous, $additionalData);
    }

    public function getTpsHttpStatusCode(): int
    {
        return HttpResponseCode::UnprocessableEntity->value;
    }

    public function getTpsCode(): int
    {
        return TpsErrorType::ERROR_TOO_OFTEN_OPERATION_CALL_CODE->value;
    }

    public function getErrorLevel(): ErrorLevel
    {
        return ErrorLevel::NOTICE;
    }
}