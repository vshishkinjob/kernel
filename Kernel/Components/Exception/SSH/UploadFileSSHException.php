<?php

namespace Kernel\Components\Exception\SSH;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class UploadFileSSHException extends BaseSSHException
{
    public function __construct(
        string $message = "Uploading file fails",
        int $code = HttpResponseCode::InternalServerError->value,
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, $code, $previous, $additionalData);
    }

    public function getErrorLevel(): ErrorLevel
    {
        return ErrorLevel::ERROR;
    }
}
