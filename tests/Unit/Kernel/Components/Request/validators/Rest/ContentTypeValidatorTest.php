<?php

namespace Unit\Kernel\Components\Request\validators\Rest;

use Codeception\Test\Unit;
use Kernel\Components\Exception\Http\BadRequestException;
use Kernel\Components\Request\Validators\Rest\ContentTypeValidator;
use Psr\Http\Message\ServerRequestInterface;

class ContentTypeValidatorTest extends Unit
{
    public function testSuccessfulValidation()
    {
        $request = $this->makeEmpty(ServerRequestInterface::class, [
            'getHeader' => function(string $header) {
                if ($header === 'content-type') {
                    return ['application/json'];
                }
                $this->fail();
            }
        ]);
        (new ContentTypeValidator())->validate($request);
    }


    public function testFailedValidation()
    {
        $request = $this->makeEmpty(ServerRequestInterface::class, [
            'getHeader' => function(string $header) {
                if ($header === 'content-type') {
                    return ['text/plain'];
                }
                $this->fail();
            }
        ]);
        $this->expectException(BadRequestException::class);
        (new ContentTypeValidator())->validate($request);
    }
}
