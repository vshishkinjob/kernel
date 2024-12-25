<?php

namespace Kernel\Components\Exception\DB;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class DuplicateException extends BaseDbException
{
    public function __construct(
        string $message = "Conflict with resource",
        int $code = HttpResponseCode::Conflict->value,
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
