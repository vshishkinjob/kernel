<?php

namespace Kernel\Components\Logger;

use InvalidArgumentException;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\Exception;
use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Exception\ErrorLevelInterface;
use Kernel\Components\Request\HttpRequestProtocols\RequestProtocolInterface;
use Kernel\Components\Request\ServerSuperGlobalHelper;
use Kernel\Components\Sentry;
use Kernel\ValueObjects\AppUniqueId;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\LogRecord;
use RuntimeException;
use Throwable;

class Monolog implements KernelLoggerInterface
{
    private string $login = 'guest';

	/**
	 * @throws RuntimeException
	 * @throws InvalidArgumentException
	 */
    public function __construct(
        private readonly Logger $loggerLib,
        private readonly ConfigFile $config,
        private readonly AppUniqueId $uniqueId,
        private readonly RequestProtocolInterface $protocol
    ) {
        $this->init();
    }

    /**
     * @param non-empty-string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

	/**
	 * @throws RuntimeException
	 * @throws InvalidArgumentException
	 */
    private function init(): void
    {
        $formatter = new JsonFormatter(JsonFormatter::BATCH_MODE_JSON);
        $formatter->setJsonPrettyPrint(true);
        $formatter->includeStacktraces();
        $formatter->setDateFormat('Y-m-d h:i:s');
        /** @var array{folder: string} $log */
        $log = $this->config->getConfigByKey('log');
        $handler = new StreamHandler($log['folder'] . '/app.log', Level::Info);
        $handler->setFormatter($formatter);
        $this->addExtraInLog($handler);
        $this->filterSensitiveData($handler);
        $this->loggerLib->setHandlers([
            $handler
        ]);
        $this->loggerLib->useLoggingLoopDetection(true);
    }

    /**
     * @return string[]
     *
     * @psalm-return array{ip: string, login: string, sessionKey: string}
     */
    private function getExtras(): array
    {
        return [
            'ip' => $this->getIp(),
            'login' => $this->getLogin(),
            'sessionKey' => $this->getSessionId()
        ];
    }

    public function addErrorLog(Throwable $e): void
    {
		Sentry::logExceptionToSentry($e);
        $context = [];
        $context['method'] = $this->protocol->getRawMethod();
        $context['params'] = $this->protocol->getRawParams();
        if ($e instanceof Exception) {
            $context['logData'] = $e->getLogData();
        }
        $context['exception'] = $e;
        if ($e instanceof ErrorLevelInterface) {
            switch ($e->getErrorLevel()) {
                case ErrorLevel::INFO:
                    $this->loggerLib->info('Info', $context);
                    break;
                case ErrorLevel::NOTICE:
                    $this->loggerLib->notice('Notice', $context);
                    break;
                case ErrorLevel::WARNING:
                    $this->loggerLib->warning('Warning', $context);
                    break;
                case ErrorLevel::CRITICAL:
                    $this->loggerLib->critical('Critical', $context);
                    break;
                case ErrorLevel::ALERT:
                    $this->loggerLib->alert('Alert', $context);
                    break;
                case ErrorLevel::EMERGENCY:
                    $this->loggerLib->emergency('Emergency', $context);
                    break;
	            default:
		            $this->loggerLib->error('Error', $context);
            }
        } else {
            $this->loggerLib->error('Server error', $context);
        }
    }

    public function addWarningLog(array $logData): void
    {
        $context = [];
        $context['method'] = $this->protocol->getRawMethod();
        $context['params'] = $this->protocol->getRawParams();
        $context['warning'] = $logData;
        $this->loggerLib->warning('Warning', $context);
    }

    public function profileMethod(string $methodClassName, array $methodArgs, float $time): void
    {
        $context = [
            'service' => LogServiceEnum::Method->value,
            'methodName' => $methodClassName,
            'methodArgs' => $methodArgs,
            'executeTime' => $time
        ];
        $this->loggerLib->info('Profile', $context);
    }

    private function getIp(): string
    {
        return ServerSuperGlobalHelper::getUserHostAddress();
    }

    private function getLogin(): string
    {
        return $this->login;
    }

    private function getSessionId(): string
    {
        return $this->uniqueId->getValue();
    }

    private function addExtraInLog(StreamHandler $handler): void
    {
        $handler->pushProcessor(function (LogRecord $record): LogRecord {
            foreach ($this->getExtras() as $key => $value) {
                $record->extra[$key] = $value;
            }
            return $record;
        });
    }

    private function filterSensitiveData(StreamHandler $handler): void
    {
        $handler->pushProcessor(function (LogRecord $record): LogRecord {
            /** @var mixed[] $context */
            $context = $record['context'];
            $result = $this->filterSensitiveRecursive($context);
            return $record->with(...['context' => $result]);
        });
    }

    /**
     * @param mixed[] $context
     * @return mixed[]
     */
    private function filterSensitiveRecursive(array $context): array
    {
        /** @var list<string> $sensitiveFields */
        $sensitiveFields = $this->config->getConfigByKey('sensitiveFields');
        foreach ($context as $key => $value) {
            if (is_string($key) && in_array(strtolower($key), $sensitiveFields, true)) {
                $context[$key] = '***';
            } elseif (is_array($value)) {
                $context[$key] = $this->filterSensitiveRecursive($value);
            }
        }
        return $context;
    }
}
