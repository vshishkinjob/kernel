<?php

namespace Unit\Kernel\Components\Request\validators\Rest;

use Codeception\Test\Unit;
use Kernel\Components\Exception\Http\BadRequestException;
use Kernel\Components\Request\Validators\Rest\JsonValidator;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class JsonValidatorTest extends Unit
{
    public function testSuccessfulValidation()
    {
        $request = $this->makeEmpty(ServerRequestInterface::class, [
            'getHeader' => function(string $header) {
                if ($header === 'content-type') {
                    return ['application/json'];
                }
                $this->fail();
            },
            'getBody' => $this->makeEmpty(StreamInterface::class, [
                'getContents' => json_encode(["some_data"])
            ])
        ]);
        (new JsonValidator())->validate($request);
    }


    public function testFailedValidation()
    {
        $request = $this->makeEmpty(ServerRequestInterface::class, [
            'getHeader' => function(string $header) {
                if ($header === 'content-type') {
                    return ['application/json'];
                }
                $this->fail();
            },
            'getBody' => $this->makeEmpty(StreamInterface::class, [
                'getContents' => "NOT_VALID_JSON"
            ])
        ]);
        $this->expectException(BadRequestException::class);
        (new JsonValidator())->validate($request);
    }
}
