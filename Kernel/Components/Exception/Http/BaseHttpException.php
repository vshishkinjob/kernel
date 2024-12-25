<?php

namespace Kernel\Components\Exception\Http;

use Kernel\Components\Exception\Exception;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

abstract class BaseHttpException extends Exception
{
    public function __construct(
        string $message = "Http error",
        int $code = HttpResponseCode::BadRequest->value,
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $code, $previous, $additionalData);
    }
}
