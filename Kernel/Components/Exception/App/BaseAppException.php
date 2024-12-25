<?php

namespace Kernel\Components\Exception\App;

use Kernel\Components\Exception\Exception;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

abstract class BaseAppException extends Exception
{
    public function __construct(
        string $message = "App error",
        int $code = HttpResponseCode::InternalServerError->value,
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $code, $previous, $additionalData);
    }
}
