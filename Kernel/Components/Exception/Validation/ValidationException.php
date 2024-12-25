<?php

namespace Kernel\Components\Exception\Validation;

use Kernel\Components\Exception\Exception;
use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class ValidationException extends Exception
{
    public function __construct(
        string $message = "Ошибка валидации",
        int $code = HttpResponseCode::UnprocessableEntity->value,
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
