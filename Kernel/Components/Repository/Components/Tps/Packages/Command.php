<?php

namespace Kernel\Components\Repository\Components\Tps\Packages;

class Command extends AbstractPackage
{
    public const COMMAND_URL = '/wooppay-command/command';
    public const COMMAND_PT = 2;

    public function getEndpoint(): string
    {
        return self::COMMAND_URL;
    }

    public function getPt(): int
    {
        return self::COMMAND_PT;
    }
}
