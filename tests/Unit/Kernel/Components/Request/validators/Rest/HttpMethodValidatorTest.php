<?php

namespace Unit\Kernel\Components\Request\validators\Rest;

use Codeception\Test\Unit;
use Kernel\Components\Exception\Http\BadRequestException;
use Kernel\Components\Exception\Http\JsonRpcErrorResponseCode;
use Kernel\Components\Exception\Http\MethodNotAllowedException;
use Kernel\Components\Request\RequestValidatorInterface;
use Kernel\Components\Request\Validators\JsonRpc\JsonValidator;
use Kernel\Components\Request\Validators\Rest\HttpMethod;
use Kernel\Components\Request\Validators\Rest\HttpMethodValidator;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class HttpMethodValidatorTest extends Unit
{
    public function testSuccessfulValidation()
    {
        $request = $this->makeEmpty(ServerRequestInterface::class, [
            'getMethod' => HttpMethod::POST->value
        ]);
        (new HttpMethodValidator())->validate($request);
    }


    public function testFailedValidation()
    {
        $request = $this->makeEmpty(ServerRequestInterface::class, [
            'getMethod' => 'GET'
        ]);
        $this->expectException(MethodNotAllowedException::class);
        (new HttpMethodValidator())->validate($request);
    }
}
