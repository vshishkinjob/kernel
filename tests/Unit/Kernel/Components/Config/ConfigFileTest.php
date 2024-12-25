<?php

namespace Unit\Kernel\Components\Config;

use Codeception\Test\Unit;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Request\HttpRequestProtocols\JsonRpc;
use Kernel\Components\Request\HttpRequestProtocols\Rest;
use Kernel\Components\Request\KernelRequest;
use Kernel\Components\Response\ResponseComponent;
use Kernel\Components\Response\ResponseFactory;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ResponseFactory as SlimResponseFactory;

class ConfigFileTest extends Unit
{
    public function testGetDataFromConfigFile()
    {
        $configFile = new ConfigFile(['test' => 'data']);

        $this->assertEquals('data', $configFile->getConfigByKey('test'));
        $this->assertNull($configFile->getConfigByKey('DO_NOT_EXISTS'));
    }
}
