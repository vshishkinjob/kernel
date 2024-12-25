<?php

namespace Unit\Kernel\Components\Request\HttpRequestProtocols;

use Codeception\Test\Unit;
use Exception;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\Http\MethodNotFoundException;
use Kernel\Components\Request\HttpRequestProtocols\Rest;
use Kernel\Components\Response\HttpResponseCode;
use Kernel\Components\Response\ResponseFactory;
use PDOException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class RestTest extends Unit
{
    protected function _before()
    {
        ResponseFactory::reset();
    }

    public function testFailWithoutMethodName()
    {
        $rest = $this->createProtocol(
            uri: '/',
            config: ['sensitiveFields' => []]
        );
        $this->expectException(MethodNotFoundException::class);
        $rest->getMethodClassName();
    }

    public function testSuccessfullyParseMethodName()
    {
        $rest = $this->createProtocol(
            uri: '/user/user-login-test',
            config: ['sensitiveFields' => []]
        );
        $className = $rest->getMethodClassName();
        $this->assertEquals('App\\Modules\\User\\Methods\\UserLoginTest', $className);
    }

    public function testSuccessfullyCreatedRequest()
    {
        $rest = $this->createProtocol(
            uri: '/user/user-login-test',
            data: ['some' => 'data'],
            files: ['some_files'],
            config: ['sensitiveFields' => []]
        );
        $this->assertEquals('App\\Modules\\User\\Methods\\UserLoginTest', $rest->getMethodClassName());
        $this->assertEquals(['some_files'], $rest->getUploadedFiles());
        $this->assertEquals(['some' => 'data'], $rest->getMethodParams());
        $this->assertEquals('/user/user-login-test', $rest->getRawMethod());
    }

    public function testJsonDecodeStringFromRequest()
    {
        $rest = $this->createProtocol(
            data: 'string_data',
            config: ['sensitiveFields' => []]
        );
        $this->assertEquals(['string_data'], $rest->getMethodParams());
        $this->assertEquals(['string_data'], $rest->getRawParams());
    }

    public function testUnescapedSlashes()
    {
        $rest = $this->createProtocol();
        $response = $rest->createResponse(ResponseFactory::getResponse(), "$(\"#output\").append(\"<p>This is a test!</p>\")");
        $response->getBody()->rewind();
        $this->assertEquals('"$(\"#output\").append(\"<p>This is a test!</p>\")"', $response->getBody()->getContents());
    }

    public function testSendRawException()
    {
        $exception = new Exception('Error message <span>');
        ob_start();
        Rest::sendRawException($exception, []);
        $result = ob_get_clean();
        $this->assertEquals('{
    "error": {
        "message": "Error message &lt;span&gt;"
    }
}', $result);
       $this->assertEquals(HttpResponseCode::InternalServerError->value, http_response_code());
    }

    public function testCommonExceptionCodeSetting()
    {
        $rest = $this->createProtocol();
        $response = $rest->createErrorResponse(
            new Exception('some_message', HttpResponseCode::ImATeapot->value),
            ResponseFactory::getResponse()
        );
        $this->assertEquals(HttpResponseCode::ImATeapot->value, $response->getStatusCode());
    }

    private function createProtocol(string $uri = '', array|string $data = [], array $files = [], array $config = []): Rest
    {
        return (new Rest(
            $this->createRequest($uri, $data, $files),
            new ConfigFile($config))
        )->init();
    }

    private function createRequest(string $uri = '', array|string $data = [], array $files = []): ServerRequestInterface
    {
        return $this->makeEmpty(ServerRequestInterface::class, [
            'getUri' => function () use ($uri) {
                return $this->makeEmpty(UriInterface::class, [
                    'getPath' => $uri,
                    '__toString' => $uri
                ]);
            },
            'getBody' => function () use ($data) {
                return $this->makeEmpty(StreamInterface::class, [
                    'getContents' => json_encode($data)
                ]);
            },
            'getUploadedFiles' => $files
        ]);
    }
}
