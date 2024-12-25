<?php

namespace Unit\Kernel\Components\Response;

use Codeception\Test\Unit;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Request\HttpRequestProtocols\JsonRpc;
use Kernel\Components\Request\HttpRequestProtocols\Rest;
use Kernel\Components\Request\KernelRequest;
use Kernel\Components\Response\ResponseComponent;
use Kernel\Components\Response\ResponseFactory;
use Psr\Http\Message\ServerRequestInterface;

class ResponseComponentTest extends Unit
{

    protected function _before(): void
    {
        ResponseFactory::reset();
    }

    public function testSuccessfullyCreatedResponseForRest()
    {
        $responseComponent = new ResponseComponent();
        $request = $this->makeEmpty(KernelRequest::class, [
            'getProtocol' => function() {
                return new Rest($this->makeEmpty(ServerRequestInterface::class), new ConfigFile(['sensitiveFields' => []]));
            }
        ]);
        $data = [
            'some' => 'result'
        ];
        $response = $responseComponent->response($data, $request);
        $this->assertEquals("application/json", $response->getHeader("content-type")[0]);
        $response->getBody()->rewind();
        $result = json_decode($response->getBody()->getContents(), true);
        $this->assertEquals('result', $result['some']);
    }

    public function testSuccessfullyCreatedResponseForJsonRpc()
    {
        $responseComponent = new ResponseComponent();
        $request = $this->makeEmpty(KernelRequest::class, [
            'getProtocol' => function() {
                return new JsonRpc($this->makeEmpty(ServerRequestInterface::class), new ConfigFile(['sensitiveFields' => []]));
            }
        ]);
        $data = [
            'some' => 'result'
        ];
        $response = $responseComponent->response($data, $request);
        $this->assertEquals("application/json", $response->getHeader("content-type")[0]);
        $response->getBody()->rewind();
        $result = json_decode($response->getBody()->getContents(), true);
        $this->assertArrayHasKey('jsonrpc', $result);
        $this->assertArrayHasKey('method', $result);
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals('result', $result['result']['some']);
    }
}
