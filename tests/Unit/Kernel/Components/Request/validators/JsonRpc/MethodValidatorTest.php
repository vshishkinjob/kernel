<?php

namespace Unit\Kernel\Components\Request\validators\JsonRpc;

use Codeception\Test\Unit;
use Kernel\Components\Exception\Http\JsonRpcErrorResponseCode;
use Kernel\Components\Exception\Http\MethodNotAllowedException;
use Kernel\Components\Request\RequestValidatorInterface;
use Kernel\Components\Request\Validators\JsonRpc\MethodValidator;
use Psr\Http\Message\ServerRequestInterface;

class MethodValidatorTest extends Unit
{
    private RequestValidatorInterface $validator;
    private ServerRequestInterface $rightServerRequest;
    private ServerRequestInterface $wrongServerRequest;


    protected function _before(): void
    {
        $this->wrongServerRequest = $this->makeEmpty(ServerRequestInterface::class, [
            'getMethod' => 'test',

        ]);

        $this->rightServerRequest = $this->makeEmpty(ServerRequestInterface::class, [
            'getMethod' => 'POST',
        ]);

        $this->validator = new MethodValidator();
    }

    public function testRightRequest()
    {
        $this->validator->validate($this->rightServerRequest);
    }

    public function testWrongRequest()
    {
        $this->expectException(MethodNotAllowedException::class);
        $this->expectExceptionCode(JsonRpcErrorResponseCode::INVALID_REQUEST->value);

        $this->validator->validate($this->wrongServerRequest);

    }
}
