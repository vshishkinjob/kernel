<?php

namespace Kernel\Components\Exception\App;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class AppNotFoundException extends BaseAppException
{
    public function __construct(
        string $message = "App not found error",
        int $code = HttpResponseCode::InternalServerError->value,
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $code, $previous, $additionalData);
    }

    public function getErrorLevel(): ErrorLevel
    {
        return ErrorLevel::CRITICAL;
    }
}
