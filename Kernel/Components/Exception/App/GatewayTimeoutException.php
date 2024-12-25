<?php

namespace Kernel\Components\Exception\App;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class GatewayTimeoutException extends BaseAppException
{
    public function __construct(
        string $message = "Gateway timeout",
        int $code = HttpResponseCode::GatewayTimeout->value,
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
