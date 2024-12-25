<?php

namespace Kernel\Components\Request;

use Kernel\Components\Method\ExecuteInterface;
use Kernel\Components\Request\HttpRequestProtocols\RequestProtocolInterface;
use Kernel\ValueObjects\Token;
use Psr\Http\Message\ServerRequestInterface;

interface RoutineInterface extends ServerRequestInterface
{
    public function getToken(): Token;

    /**
     * @return class-string<ExecuteInterface>
     */
    public function getRequestMethodClassName(): string;

    /**
     * @return array<string, mixed>
     */
    public function getMethodParams(): array;

    public function getProtocol(): RequestProtocolInterface;
}
