<?php

namespace Kernel\Components\Request;

use InvalidArgumentException;
use Kernel\Components\Request\HttpRequestProtocols\RequestProtocolInterface;
use Kernel\ValueObjects\Token;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class RequestCreatorMiddleware implements MiddlewareInterface
{
    public function __construct(
        private RequestProtocolInterface $protocol,
        private Token $token
    ) {
    }

    /**
     * @param RoutineInterface $request
     * @throws InvalidArgumentException
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $request = new KernelRequest($request, $this->protocol, $this->token);
        return $handler->handle($request);
    }
}
