<?php

declare(strict_types=1);

namespace Kernel\Components\Exception\TPS\Exceptions;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Exception\TPS\BaseTpsException;
use Kernel\Components\Exception\TpsErrorType;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class SubjectWrongIpTpsException extends BaseTpsException
{
    public function __construct(
        string $message = "Subject wrong ip",
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $previous, $additionalData);
    }

    public function getTpsHttpStatusCode(): int
    {
        return HttpResponseCode::Forbidden->value;
    }

    public function getTpsCode(): int
    {
        return TpsErrorType::ERROR_SUBJECT_WRONG_IP->value;
    }

    public function getErrorLevel(): ErrorLevel
    {
        return ErrorLevel::NOTICE;
    }
}
