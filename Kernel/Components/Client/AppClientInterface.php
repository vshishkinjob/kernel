<?php

namespace Kernel\Components\Client;

use Psr\Http\Message\ResponseInterface;

interface AppClientInterface
{
    //Возможность переопределить дефолтные значения клиента
    /**
     * @param mixed[] $config
     */
    public function setClientWithConfig(array $config = []): void;

    /**
     * @param non-empty-string $method
     * @param non-empty-string $uri
     * @param mixed[] $options
     */
    public function sendRequest(string $method, string $uri, array $options = []): ResponseInterface;
}
