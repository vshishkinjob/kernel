<?php

namespace Kernel\Components\Exception\Http;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class TooManyRequestException extends BaseHttpException
{
    public function __construct(
        string $message = "Too many request",
        int $code = HttpResponseCode::TooManyRequests->value,
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $code, $previous, $additionalData);
    }

    public function getErrorLevel(): ErrorLevel
    {
        return ErrorLevel::NOTICE;
    }
}
