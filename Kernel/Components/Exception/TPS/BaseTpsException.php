<?php

namespace Kernel\Components\Exception\TPS;

use Kernel\Components\Exception\Exception;
use Throwable;

abstract class BaseTpsException extends Exception
{
    public function __construct(
        string $message = "",
        ?Throwable $previous = null,
        array $additionalData = []
    ) {
        parent::__construct($message, static::redefinedTpsCode() ?? $this->getTpsCode(), $previous, $additionalData);
    }

    abstract public function getTpsCode(): int;

    public static function redefinedTpsCode(): int|null
    {
        return null;
    }

    public function getHttpStatusCode(): int
    {
        return $this->getTpsHttpStatusCode();
    }

    abstract public function getTpsHttpStatusCode(): int;
}
