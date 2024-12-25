<?php

namespace Unit\Kernel\Components\Response;

use Codeception\Test\Unit;
use Kernel\Components\Response\HttpResponseCode;
use Kernel\Components\Response\ResponseFactory;
use Psr\Http\Message\ResponseInterface;

class ResponseFactoryTest extends Unit
{
    protected function _before(): void
    {
        ResponseFactory::reset();
    }

    public function testGetResponseFactory()
    {
        $response = ResponseFactory::getResponse();
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(HttpResponseCode::Ok->value, $response->getStatusCode());
    }

    public function testRestResponseFactory()
    {
        $response = ResponseFactory::getResponse();
        $response->withStatus(HttpResponseCode::InternalServerError->value);
        ResponseFactory::reset();
        $response = ResponseFactory::getResponse();
        $this->assertEquals(HttpResponseCode::Ok->value, $response->getStatusCode());
    }
}
