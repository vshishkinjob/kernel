<?php

namespace Kernel\Components\Exception\DB;

use Kernel\Components\Exception\Exception;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

abstract class BaseDbException extends Exception
{
    public function __construct(
        string $message = "Db error",
        int $code = HttpResponseCode::InternalServerError->value,
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $code, $previous, $additionalData);
    }
}
