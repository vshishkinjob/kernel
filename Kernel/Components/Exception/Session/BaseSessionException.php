<?php

namespace Kernel\Components\Exception\Session;

use Kernel\Components\Exception\Exception;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

abstract class BaseSessionException extends Exception
{
    public function __construct(
        string $message = "Session error",
        int $code = HttpResponseCode::InternalServerError->value,
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $code, $previous, $additionalData);
    }
}
