<?php

namespace Kernel\Components\Exception\App;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class InvalidReflectionTypeException extends BaseAppException
{
    public function __construct(
        string $message = "Invalid property reflection type",
        int $code = HttpResponseCode::InternalServerError->value,
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $code, $previous, $additionalData);
    }

    public function getErrorLevel(): ErrorLevel
    {
        return ErrorLevel::ERROR;
    }
}
