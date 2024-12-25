<?php

declare(strict_types=1);

namespace Kernel\Components\Exception\TPS;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class UndefinedTpsException extends BaseTpsException
{
    public function __construct(
        string $message = "Undefined Tps exception",
        ?Throwable $previous = null,
        array $additionalData = [],
        private int $tpsCode = 0
    ) {
        parent::__construct($message, $previous, $additionalData);
    }

    public function getTpsCode(): int
    {
        return $this->tpsCode;
    }

    public function getTpsHttpStatusCode(): int
    {
        return HttpResponseCode::InternalServerError->value;
    }

    public function getErrorLevel(): ErrorLevel
    {
        return ErrorLevel::CRITICAL;
    }
}
