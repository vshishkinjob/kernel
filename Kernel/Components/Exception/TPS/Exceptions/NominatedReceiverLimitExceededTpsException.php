<?php

namespace Kernel\Components\Exception\TPS\Exceptions;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Exception\TPS\BaseTpsException;
use Kernel\Components\Exception\TpsErrorType;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class NominatedReceiverLimitExceededTpsException extends BaseTpsException
{
    public function __construct(
        string $message = "Nominated receiver limit exceeded",
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
        return TpsErrorType::ERROR_NOMINATED_RECEIVER_LIMIT_EXCEEDED->value;
    }

    public function getErrorLevel(): ErrorLevel
    {
        return ErrorLevel::NOTICE;
    }
}
