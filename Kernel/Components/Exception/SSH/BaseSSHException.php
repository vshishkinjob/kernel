<?php

namespace Kernel\Components\Exception\SSH;

use Kernel\Components\Exception\Exception;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

abstract class BaseSSHException extends Exception
{
    public function __construct(
        string $message = "File error",
        int $code = HttpResponseCode::InternalServerError->value,
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $code, $previous, $additionalData);
    }
}
