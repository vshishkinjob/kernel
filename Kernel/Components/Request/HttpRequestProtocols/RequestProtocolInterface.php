<?php

namespace Kernel\Components\Request\HttpRequestProtocols;

use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\Method\ExecuteInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Throwable;

interface RequestProtocolInterface
{
    public function init(): self;

    /**
     * @return  array<string,mixed>
     */
    public function getMethodParams(): array;

    /**
     * @return class-string<ExecuteInterface>
     */
    public function getMethodClassName(): string;

    public function createResponse(ResponseInterface $response, mixed $responseData): ResponseInterface;

    public function createErrorResponse(
        Throwable $exception,
        ResponseInterface $response
    ): ResponseInterface;

    /**
     * @return array<string, UploadedFileInterface|list<UploadedFileInterface>>
     * @throws FileNotFoundException
     */
    public function getUploadedFiles(): array;

    public function getRawMethod(): string;

    /**
     * @return array<array-key, mixed>
     */
    public function getRawParams(): array;
}
