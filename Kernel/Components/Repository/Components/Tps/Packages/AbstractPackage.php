<?php

namespace Kernel\Components\Repository\Components\Tps\Packages;

abstract class AbstractPackage
{
    protected string $url;
    protected int $pt;
    protected int $upid = 0;

    public function __construct()
    {
        $this->url = $this->getEndpoint();
        $this->pt = $this->getPt();
    }

    /**
     * @return non-empty-string
     */
    abstract public function getEndpoint(): string;

    abstract public function getPt(): int;

    /**
     * @return int
     */
    public function getUpid(): int
    {
        return $this->upid;
    }
}
