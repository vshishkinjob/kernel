<?php

namespace Kernel\Components\Repository\Components\Tps\Packages;

class Report extends AbstractPackage
{
    public const REPORT_URL = '/wooppay-report/report';
    public const REPORT_PT = 4;

    public function getEndpoint(): string
    {
        return self::REPORT_URL;
    }

    public function getPt(): int
    {
        return self::REPORT_PT;
    }
}
