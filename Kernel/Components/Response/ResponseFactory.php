<?php

declare(strict_types=1);

namespace Kernel\Components\Response;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Factory\ResponseFactory as SlimResponseFactory;

class ResponseFactory
{
    private static ?ResponseInterface $response = null;

    private function __construct()
    {
    }

    public static function getResponse(): ResponseInterface
    {
        if (self::$response === null) {
            self::$response = self::createResponse();
        }
        return self::$response;
    }

    public static function setResponse(ResponseInterface $response): void
    {
        self::$response = $response;
    }

    public static function reset(): void
    {
        self::$response = null;
    }

    private static function createResponse(): ResponseInterface
    {
        return (new SlimResponseFactory())->createResponse(200);
    }
}
