<?php

namespace Kernel\Components\Request;

use Kernel\Components\Method\MethodComponentInterface;
use Kernel\Components\Response\KernelResponseInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class RequestComponent implements MiddlewareInterface
{
    public function __construct(
        private MethodComponentInterface $methodComponent,
        private KernelResponseInterface $responseComponent
    ) {
    }

    /**
     * @param RoutineInterface $request
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $result = $this->methodComponent->runMethodFromRequest($request);
        return $this->responseComponent->response($result, $request);
    }
}
