<?php

namespace Kernel\Components\Logger;

use Throwable;

interface KernelLoggerInterface
{
    /**
     * @param array<string, mixed> $methodArgs
     */
    public function profileMethod(string $methodClassName, array $methodArgs, float $time): void;

    public function addErrorLog(Throwable $e): void;

    /** @param array<string, mixed> $logData */
    public function addWarningLog(array $logData): void;

    public function setLogin(string $login): void;
}
