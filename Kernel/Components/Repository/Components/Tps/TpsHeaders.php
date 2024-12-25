<?php

namespace Kernel\Components\Repository\Components\Tps;

use Kernel\Components\Request\ServerSuperGlobalHelper;
use Kernel\ValueObjects\AppUniqueId;
use Kernel\ValueObjects\Token;

class TpsHeaders
{
    /**
     * @var array<string, string> $repositoryHeaders
     */
    private array $repositoryHeaders = [];

    public function __construct(
        private readonly Token $token,
        private AppUniqueId $uniqueId
    ) {
    }

    /**
     * @return array<string, string>
     */
    public function getRepositoryHeaders(): array
    {
        return $this->repositoryHeaders + $this->getDefaultHeaders();
    }

    /**
     * @return array<string, string>
     */
    private function getDefaultHeaders(): array
    {
        return [
            "secret-key" => $this->token->getValue() ?? '',
            "client-ip" => ServerSuperGlobalHelper::getUserHostAddress(),
            "wsdl-request" => $this->uniqueId->getValue(),
            "Connection" => "Keep-Alive"
        ];
    }

    /** @param array<string, string> $repositoryHeaders */
    public function setRepositoryHeaders(array $repositoryHeaders): void
    {
        $this->repositoryHeaders = $repositoryHeaders;
    }
}
