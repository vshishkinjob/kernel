<?php

namespace Unit\Kernel\Components\Request\HttpRequestProtocols;

use Codeception\Test\Unit;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Request\HttpRequestProtocols\AbstractProtocol;
use Kernel\Components\Request\HttpRequestProtocols\RequestProtocolInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AbstractProtocolTest extends Unit
{
    public function testHideSensitiveData()
    {
        $sensitiveMessage = ' THIS SOME DATA WHICH CONTAIN password SENSITVIE FIELD!';
        $notSensitiveMessage = ' THIS SOME DATA WHICH DO NOT CONTAIN SENSITVIE FIELD!';
        $sensitiveFields = ['password'];
        $protocol = $this->createEmptyAbstractProtocol();
        $this->assertEquals(
            'String contains sensitive data!',
            $protocol->callHideIfHaveSensitiveDataFunction($sensitiveMessage, $sensitiveFields)
        );
        $this->assertEquals(
            ' THIS SOME DATA WHICH DO NOT CONTAIN SENSITVIE FIELD!',
            $protocol->callHideIfHaveSensitiveDataFunction($notSensitiveMessage, $sensitiveFields)
        );
    }

    private function createEmptyAbstractProtocol(array $config = []): AbstractProtocol
    {
        $configFile = new ConfigFile($config);

        return new class($configFile) extends AbstractProtocol {

            public function callHideIfHaveSensitiveDataFunction(string $message, array $sensitiveFields): string
            {
                return self::hideIfHaveSensitiveData($message, $sensitiveFields);
            }

            protected function validate(): void
            {
            }

            public static function sendRawException(Throwable $e, array $sensitiveFields): void
            {
            }

            public function init(): RequestProtocolInterface
            {
            }

            public function getMethodParams(): array
            {
            }

            public function getMethodClassName(): string
            {
            }

            public function createResponse(ResponseInterface $response, mixed $responseData): ResponseInterface
            {
            }

            public function createErrorResponse(Throwable $exception, ResponseInterface $response): ResponseInterface
            {
            }

            public function getUploadedFiles(): array
            {
            }

            public function getRawMethod(): string
            {
            }

            public function getRawParams(): array
            {
            }
        };
    }
}
