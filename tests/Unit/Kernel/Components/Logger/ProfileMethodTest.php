<?php

namespace Unit\Kernel\Components\Logger;

use Codeception\Test\Unit;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Logger\KernelLoggerInterface;
use Kernel\Components\Logger\LogServiceEnum;
use Kernel\Components\Logger\Monolog;
use Kernel\Components\Request\HttpRequestProtocols\RequestProtocolInterface;
use Kernel\ValueObjects\AppUniqueId;
use Monolog\Logger;
use Yiisoft\Session\SessionInterface;

class ProfileMethodTest extends Unit
{
    private KernelLoggerInterface $logger;
    private array $infoMessage;

    protected function _before(): void
    {
        $logger = $this->make(Logger::class, [
            'info' => function(string $message, array $context) {
                $this->infoMessage = [
                    'message' => $message,
                    'context' => $context
                ];
            }
        ]);
        $config = $this->makeEmpty(ConfigFile::class);
        $this->logger = new Monolog($logger, $config, new AppUniqueId(), $this->makeEmpty(RequestProtocolInterface::class));
    }

    public function testProfileMethod()
    {
        $testClassName = 'testClassName';
        $arguments = ['test' => 1,];
        $time = rand(1, 10) / 10;

        $this->logger->profileMethod($testClassName, $arguments, $time);

        $this->assertNotEmpty($this->infoMessage);
        $this->assertNotEmpty($this->infoMessage['message']);
        $this->assertNotEmpty($this->infoMessage['context']);
        $this->assertNotEmpty($this->infoMessage['context']['service']);
        $this->assertNotEmpty($this->infoMessage['context']['methodName']);
        $this->assertNotEmpty($this->infoMessage['context']['methodArgs']);
        $this->assertNotEmpty($this->infoMessage['context']['executeTime']);

        $this->assertEquals($testClassName, $this->infoMessage['context']['methodName']);
        $this->assertEquals($arguments, $this->infoMessage['context']['methodArgs']);
        $this->assertEquals($time, $this->infoMessage['context']['executeTime']);
        $this->assertEquals(LogServiceEnum::Method->value, $this->infoMessage['context']['service']);
    }

    protected function _after(): void
    {
        $this->infoMessage = [];
    }
}
