<?php

namespace Kernel\Components\Request;

use Kernel\Components\Method\ExecuteInterface;
use Kernel\Components\Request\HttpRequestProtocols\RequestProtocolInterface;
use Kernel\ValueObjects\Token;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Cookies;
use Slim\Psr7\Headers;
use Slim\Psr7\Request;

class KernelRequest extends Request implements RoutineInterface
{
    /**
     * @var class-string<ExecuteInterface>
     */
    private string $methodClassName;

    /**
     * @var array<string,mixed>
     */
    private array $methodParams;

    private RequestProtocolInterface $protocol;

    public function __construct(
        ServerRequestInterface $request,
        RequestProtocolInterface $protocol,
        private readonly Token $token
    ) {
        $this->protocol = $protocol->init();
        $headers = Headers::createFromGlobals();
        $cookies = Cookies::parseHeader($headers->getHeader('Cookie'));
        parent::__construct(
            $request->getMethod(),
            $request->getUri(),
            $headers,
            $cookies,
            $request->getServerParams(),
            $request->getBody(),
            $request->getUploadedFiles()
        );
        $this->methodClassName = $this->protocol->getMethodClassName();
        $this->methodParams = $this->protocol->getMethodParams();
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function getRequestMethodClassName(): string
    {
        return $this->methodClassName;
    }

    public function getMethodParams(): array
    {
        return $this->methodParams;
    }

    /**
     * @return RequestProtocolInterface
     */
    public function getProtocol(): RequestProtocolInterface
    {
        return $this->protocol;
    }
}
