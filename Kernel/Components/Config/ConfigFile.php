<?php

declare(strict_types=1);

namespace Kernel\Components\Config;

class ConfigFile
{
    public function __construct(
        /** @var array<string, mixed> $configs */
        private readonly array $configs
    ) {
    }

    public function getConfigByKey(string $key): mixed
    {
        return $this->configs[$key] ?? null;
    }
}
