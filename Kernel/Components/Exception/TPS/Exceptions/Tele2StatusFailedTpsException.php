<?php

namespace Kernel\Components\Exception\TPS\Exceptions;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Exception\TPS\BaseTpsException;
use Kernel\Components\Exception\TpsErrorType;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class Tele2StatusFailedTpsException extends BaseTpsException
{
    public function __construct(
        string $message = "Tele2 status failed",
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
        return TpsErrorType::ERROR_TELE2_STATUS_FAILED->value;
    }

    public function getErrorLevel(): ErrorLevel
    {
        return ErrorLevel::NOTICE;
    }
}