<?php

namespace Kernel\Components\Client;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class GuzzleClient implements AppClientInterface
{
    public function __construct(private ClientInterface $client)
    {
    }

    public function setClientWithConfig(array $config = []): void
    {
        $this->client = new Client($config);
    }

	/**
	 * @throws GuzzleException
	 */
    public function sendRequest(string $method, string $uri, array $options = []): ResponseInterface
    {
        return $this->client->request($method, $uri, $options);
    }
}
