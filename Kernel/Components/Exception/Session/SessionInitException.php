<?php

declare(strict_types=1);

namespace Kernel\Components\Exception\Session;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class SessionInitException extends BaseSessionException
{
    public function __construct(
        string $message = "Unable to init session!",
        int $code = HttpResponseCode::InternalServerError->value,
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $code, $previous, $additionalData);
    }

    public function getErrorLevel(): ErrorLevel
    {
        return ErrorLevel::ALERT;
    }
}
