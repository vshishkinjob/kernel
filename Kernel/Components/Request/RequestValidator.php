<?php

namespace Kernel\Components\Request;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class RequestValidator implements MiddlewareInterface
{
    /**
     * Validator constructor.
     * @param RequestValidatorInterface[] $validators
     */
    public function __construct(private array $validators)
    {
    }

    /**
     * @param RoutineInterface $request
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        foreach ($this->validators as $validator) {
            $validator->validate($request);
        }

        return $handler->handle($request);
    }
}
