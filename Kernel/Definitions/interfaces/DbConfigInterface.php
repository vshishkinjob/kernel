<?php

namespace Kernel\Definitions\interfaces;

interface DbConfigInterface
{
    /**
     * @return non-empty-string
     */
    public function getDbName(): string;

    /**
     * @return non-empty-string
     */
    public function getHost(): string;

    /**
     * @return int<1, max>
     */
    public function getPort(): int;

    /**
     * @return non-empty-string
     */
    public function getUser(): string;

    /**
     * @return non-empty-string
     */
    public function getPassword(): string;

    /**
     * @return non-empty-string[]
     */
    public function getSchema(): array;
}
