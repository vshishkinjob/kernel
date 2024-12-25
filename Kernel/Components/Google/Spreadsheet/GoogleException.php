<?php

namespace Kernel\Components\Google\Spreadsheet;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Exception\Http\BaseHttpException;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

final class GoogleException extends BaseHttpException
{
    public function __construct(
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct("Возникли проблемы при взаимодействии с Google API.", HttpResponseCode::BadRequest->value, $previous, $additionalData);
    }

    public function getErrorLevel(): ErrorLevel
    {
        return ErrorLevel::ERROR;
    }
}
