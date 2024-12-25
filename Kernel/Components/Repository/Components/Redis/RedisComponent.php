<?php

namespace Kernel\Components\Repository\Components\Redis;

use Kernel\Components\Config\ConfigFile;
use Redis;
use RedisException;

class RedisComponent
{
    private Redis $client;

	/**
	 * @throws RedisException
	 */
    public function __construct(private readonly ConfigFile $config)
    {
        $this->client = new Redis();
        /** @var array{host: string, port: int} $redis */
        $redis = $this->config->getConfigByKey('redis');
        $this->client->connect(
            host: $redis['host'],
            port: $redis['port']
        );
    }

    public function getClient(): Redis
    {
        return $this->client;
    }
}
