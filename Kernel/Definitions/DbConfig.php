<?php

namespace Kernel\Definitions;

use Kernel\Components\Config\ConfigFile;
use Kernel\Definitions\interfaces\DbConfigInterface;

final class DbConfig implements DbConfigInterface
{
    /** @var non-empty-string $dbName  */
    private readonly string $dbName;
    /** @var non-empty-string $host  */
    private readonly string $host;
    /** @var int<1,max> $port */
    private readonly int $port;
    /** @var non-empty-string $user  */
    private readonly string $user;
    /** @var non-empty-string $password  */
    private readonly string $password;
    /** @var non-empty-string[] $schema  */
    private readonly array $schema;

    public function __construct(
        private readonly ConfigFile $config
    ) {
        /**
         * @var array{
         *      dbName: non-empty-string,
         *      host: non-empty-string,
         *      port: int<1,max>,
         *      user: non-empty-string,
         *      password: non-empty-string,
         *      availableSchemas: non-empty-string[]
         * } $config
         */
        $config = $this->config->getConfigByKey('db');
        $this->dbName = $config['dbName'];
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->user = $config['user'];
        $this->password = $config['password'];
        $this->schema = $config['availableSchemas'];
    }

    public function getDbName(): string
    {
        return $this->dbName;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    /** @return int<1,max> */
    public function getPort(): int
    {
        return $this->port;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSchema(): array
    {
        return $this->schema;
    }
}
