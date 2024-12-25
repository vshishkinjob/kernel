<?php

namespace Kernel\Components\Exception\File;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class IncorrectFileFormatException extends BaseFileException
{
    public function __construct(
        string $message = "Incorrect file format",
        int $code = HttpResponseCode::UnsupportedMediaType->value,
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
