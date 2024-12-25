<?php

namespace Kernel\Components\Exception\Validation;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class Base64ValidationException extends ValidationException
{
    public function __construct(
        string $message = "Строка должна быть закодирована в base64 формате!",
        int $code = HttpResponseCode::BadRequest->value,
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
