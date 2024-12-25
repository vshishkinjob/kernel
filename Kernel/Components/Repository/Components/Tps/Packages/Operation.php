<?php

namespace Kernel\Components\Repository\Components\Tps\Packages;

class Operation extends AbstractPackage
{
    public const OPERATION_URL = '/wooppay-cash/cash';
    public const OPERATION_PT = 3;

    public function getEndpoint(): string
    {
        return self::OPERATION_URL;
    }

    public function getPt(): int
    {
        return self::OPERATION_PT;
    }
}
