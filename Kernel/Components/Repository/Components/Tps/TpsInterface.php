<?php

namespace Kernel\Components\Repository\Components\Tps;

use Kernel\Components\Repository\Components\BaseEntity;
use Kernel\Components\Repository\Components\Tps\Commands\Commands;
use Kernel\Components\Repository\Components\Tps\Commands\OperationCommands;
use Kernel\Components\Repository\Components\Tps\Commands\ReportCommands;

interface TpsInterface
{
    public function getCommand(): OperationCommands|Commands|ReportCommands;

    /** @return array<string, mixed> */
    public function getRequestBody(): array;

    /** @return array<string, string> */
    public function getRequestHeaders(): array;
}
