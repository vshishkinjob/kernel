<?php

namespace Kernel\Definitions;

use Kernel\Components\Config\ConfigFile;

final class StaticConfig
{
    public function __construct(private readonly ConfigFile $config)
    {
        /**
         * @var array{
         *     port: int,
         *     host: string,
         *     sshKeyFolder: string,
         *     passphrase?: string,
         *     username?: string,
         *     resourcePath?: string
         * } $config
         */
        $config = $this->config->getConfigByKey('static');
        $this->port = $config['port'];
        $this->staticUrl = $this->config->getConfigByKey('environment') === Environment::PROD
            ? 'https://static.wooppay.com/'
            : 'https://static.test.wooppay.com/';

        $this->privateKeyPath = $config['sshKeyFolder'] . '/static.ppk';
        $this->publicKeyPath = $config['sshKeyFolder'] . '/static.pub';
        $this->address = $config['host'];
        $this->passphrase = $config['passphrase'] ?? '';
        $this->username = $config['username'] ?? 'static';
        $this->resourcePath = $config['resourcePath'] ?? '/usr/share/nginx/html/';
    }

    public string $privateKeyPath;
    public string $publicKeyPath;

    /** Конфигурации подключения START*/
    public string $resourcePath;
    public string $address;
    public string $passphrase;

    public int $port;

    public string $username;
    /** конфигурации подключения END*/

    public string $staticUrl;
}
