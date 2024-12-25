<?php

namespace Unit\Kernel\Components\Logger;

use Codeception\Test\Unit;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Logger\KernelLoggerInterface;
use Kernel\Components\Logger\Monolog;
use Kernel\Components\Request\HttpRequestProtocols\RequestProtocolInterface;
use Kernel\ValueObjects\AppUniqueId;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface;

class ServerErrorTest extends Unit
{
    private KernelLoggerInterface $logger;
    private array $errorMessage;

    protected function _before(): void
    {
        $logger = $this->make(Logger::class, [
            'error' => function(string $message, array $context) {
                $this->errorMessage = [
                    'message' => $message,
                    'context' => $context
                ];
            },
        ]);
        $config = $this->makeEmpty(ConfigFile::class);
        $this->logger = new Monolog($logger, $config, new AppUniqueId(), $this->makeEmpty(RequestProtocolInterface::class));
    }

    public function testServerError()
    {
        $exception = new \Exception('Some error');
        $this->logger->addErrorLog($exception);

        $this->assertNotEmpty($this->errorMessage);
        $this->assertNotEmpty($this->errorMessage['message']);
        $this->assertNotEmpty($this->errorMessage['context']);
        $this->assertNotEmpty($this->errorMessage['context']['exception']);
        $this->assertEquals($exception, $this->errorMessage['context']['exception']);
    }

    protected function _after(): void
    {
        $this->errorMessage = [];
    }
}
