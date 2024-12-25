<?php

namespace Unit\Kernel\Components\Request\HttpRequestProtocols;

use Codeception\Test\Unit;
use Exception;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\App\AppNotFoundException;
use Kernel\Components\Exception\Http\BadRequestException;
use Kernel\Components\Exception\Http\JsonRpcErrorResponseCode;
use Kernel\Components\Request\HttpRequestProtocols\JsonRpc;
use Kernel\Components\Response\HttpResponseCode;
use Kernel\Components\Response\ResponseFactory;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class JsonRpcTest extends Unit
{
    protected function _before()
    {
        ResponseFactory::reset();
    }

    public function testInvalidJsonRpcVersionRequestWillFail()
    {
        $this->expectExceptionCode(JsonRpcErrorResponseCode::INVALID_PARAMS->value);
        $this->expectException(BadRequestException::class);
        $this->createProtocol(json_encode([
            "jsonrpc" => "1.0"
        ]),['sensitiveFields' => []]);
    }

    public function testEmptyMethodRequestWillFail()
    {
        $this->expectExceptionCode(JsonRpcErrorResponseCode::INVALID_PARAMS->value);
        $this->expectException(BadRequestException::class);
        $this->createProtocol(json_encode([
            "jsonrpc" => "2.0"
        ]),['sensitiveFields' => []]);
    }

    public function testCorrectJsonRpcConvertedToObject()
    {
        $rpc = $this->createProtocol(json_encode([
            'id' => 1000,
            "jsonrpc" => "2.0",
            "method" => "some/method",
            "params" => [
                "test" => "test"
            ],
        ]), ['sensitiveFields' => []]);
        $this->assertInstanceOf(JsonRpc::class, $rpc);
        $this->assertEquals(1000, $rpc->getId());
        $this->assertEquals("2.0", $rpc->getJsonrpc());
        $this->assertEquals('some/method', $rpc->getMethod());
        $this->assertEquals('some/method', $rpc->getRawMethod());
        $this->assertEquals(['test' => 'test'], $rpc->getParams());
        $this->assertEquals(['test' => 'test'], $rpc->getRawParams());
    }

    public function testErrorThrownIfInvalidContent()
    {
        $this->expectException(BadRequestException::class);
        $this->createProtocol(json_encode(null));
    }

    public function testGetMethodClassName()
    {
        $rpc = $this->createProtocol(json_encode([
            "jsonrpc" => "2.0",
            "method" => "some/method",
            "params" => [
                "test" => "test"
            ],
        ]), ['sensitiveFields' => []]);
        $this->assertEquals('App\Modules\Some\Methods\Method', $rpc->getMethodClassName());
    }

    public function testUnescapedSlashes()
    {
        $rest = $this->createProtocol(json_encode([
            "jsonrpc" => "2.0",
            "method" => "some/method"
        ]));
        $response = $rest->createResponse(ResponseFactory::getResponse(), "$(\"#output\").append(\"<p>This is a test!</p>\")");
        $response->getBody()->rewind();
        $this->assertEquals(
            '{"jsonrpc":"2.0","method":"some/method","id":null,"result":"$(\"#output\").append(\"<p>This is a test!</p>\")"}',
            $response->getBody()->getContents()
        );
    }

    public function testSendRawExceptionWithKernelException()
    {
        $exception = new AppNotFoundException(message: 'Error message <span>', additionalData: ['someAdditional']);
        ob_start();
        JsonRpc::sendRawException($exception, []);
        $result = ob_get_clean();
        $this->assertEquals('{
    "jsonrpc": "2.0",
    "error": {
        "code": 500,
        "message": "Error message &lt;span&gt;",
        "details": [
            "someAdditional"
        ]
    }
}', $result);
        $this->assertEquals(HttpResponseCode::Ok->value, http_response_code());
    }

    public function testSendRawExceptionWithPHPException()
    {
        $exception = new Exception(message: 'Error message <span>');
        ob_start();
        JsonRpc::sendRawException($exception, []);
        $result = ob_get_clean();
        $this->assertEquals('{
    "jsonrpc": "2.0",
    "error": {
        "code": 0,
        "message": "Error message &lt;span&gt;"
    }
}', $result);
        $this->assertEquals(HttpResponseCode::Ok->value, http_response_code());
    }

    private function createProtocol(string $requestJson, array $config = []): JsonRpc
    {
        return (new JsonRpc($this->createRequest($requestJson), new ConfigFile($config)))->init();
    }

    private function createRequest(string $requestJson): ServerRequestInterface
    {
        $stream = $this->makeEmpty(StreamInterface::class, [
            'getContents' => function () use ($requestJson) {
                return $requestJson;
            }
        ]);

        return $this->makeEmpty(ServerRequestInterface::class, [
            'getBody' => function () use ($stream) {
                return $stream;
            }
        ]);
    }
}
