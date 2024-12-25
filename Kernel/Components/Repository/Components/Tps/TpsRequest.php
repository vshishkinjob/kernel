<?php

namespace Kernel\Components\Repository\Components\Tps;

use Kernel\Components\Exception\App\AppNotFoundException;
use Kernel\Components\Repository\Components\Tps\Commands\Commands;
use Kernel\Components\Repository\Components\Tps\Commands\OperationCommands;
use Kernel\Components\Repository\Components\Tps\Commands\ReportCommands;

readonly class TpsRequest
{
    private TpsRequestBody $requestBody;

    /**
     * @param array<string,mixed> $bodyParams
     * @throws AppNotFoundException
     */
    public function __construct(
        Commands|OperationCommands|ReportCommands $command,
        array $bodyParams,
        private TpsHeaders $headers
    ) {
        $this->requestBody = $this->getRequestBody($command, $bodyParams);
    }

    /**
     * @param array<string,mixed> $bodyParams
     * @throws AppNotFoundException
     */
    private function getRequestBody(
        Commands|OperationCommands|ReportCommands $command,
        array $bodyParams
    ): TpsRequestBody {
        return new TpsRequestBody($command, $bodyParams);
    }

    /**
     * @return array{
     *     json:array{pt:int,upid:int,operation?:int,reportType?:int,command?:int,parameters?:array<array-key, mixed>},
     *     headers:array<string, string>
     *  }
     */
    public function getOptions(): array
    {
        return [
            'json' => $this->requestBody->getCommonBodyStructure(),
            'headers' => $this->headers->getRepositoryHeaders()
        ];
    }

    /**
     * @return non-empty-string
     */
    public function getUrl(): string
    {
        return $this->requestBody->getUrl();
    }
}
