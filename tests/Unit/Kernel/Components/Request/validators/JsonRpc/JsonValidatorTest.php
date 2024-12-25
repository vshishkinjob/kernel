<?php

namespace Unit\Kernel\Components\Request\validators\JsonRpc;

use Codeception\Test\Unit;
use Kernel\Components\Exception\Http\BadRequestException;
use Kernel\Components\Exception\Http\JsonRpcErrorResponseCode;
use Kernel\Components\Request\RequestValidatorInterface;
use Kernel\Components\Request\Validators\JsonRpc\JsonValidator;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class JsonValidatorTest extends Unit
{
    private RequestValidatorInterface $validator;
    private ServerRequestInterface $rightServerRequest;
    private ServerRequestInterface $wrongServerRequest;


    protected function _before(): void
    {
        $stream = $this->makeEmpty(StreamInterface::class, [
            'getContents' => '{}'
        ]);

        $this->wrongServerRequest = $this->makeEmpty(ServerRequestInterface::class, [
            'getHeader' => ['test'],
            'getBody' => $stream
        ]);

        $this->rightServerRequest = $this->makeEmpty(ServerRequestInterface::class, [
           'getHeader' => ['application/json'],
           'getBody' => $stream
        ]);

        $this->validator = new JsonValidator();
    }

    public function testRightRequest()
    {
        $this->validator->validate($this->rightServerRequest);
    }

    public function testWrongRequest()
    {
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(JsonRpcErrorResponseCode::PARSE_ERROR->value);

        $this->validator->validate($this->wrongServerRequest);
    }
}
