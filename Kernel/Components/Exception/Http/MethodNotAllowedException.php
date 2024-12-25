<?php

namespace Kernel\Components\Exception\Http;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class MethodNotAllowedException extends BaseHttpException
{
    public function __construct(
        string $message = "Method not allowed",
        int $code = HttpResponseCode::MethodNotAllowed->value,
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
