<?php

namespace Kernel\Components\Exception\DB;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class EntityNotFoundException extends BaseDbException
{
    public function __construct(
        string $message = "Entity not found",
        int $code = HttpResponseCode::NotFound->value,
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