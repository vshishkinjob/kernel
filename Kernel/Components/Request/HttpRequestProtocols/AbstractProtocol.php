<?php

namespace Kernel\Components\Request\HttpRequestProtocols;

use Kernel\Components\Config\ConfigFile;
use Throwable;

abstract class AbstractProtocol implements RequestProtocolInterface
{
    public function __construct(protected readonly ConfigFile $configFile)
    {
    }

    abstract protected function validate(): void;

    /** @param list<string> $sensitiveFields */
    abstract public static function sendRawException(Throwable $e, array $sensitiveFields): void;

    /**
     * @param mixed[] $context
     * @return mixed[]
     */
    protected function filterSensitiveRecursive(array $context): array
    {
        /** @var list<string> $sensitiveFields */
        $sensitiveFields = $this->configFile->getConfigByKey('sensitiveFields');
        if (!is_array($sensitiveFields)) {
            return $context;
        }

        foreach ($context as $key => $value) {
            if (is_string($key) && in_array(strtolower($key), $sensitiveFields, true)) {
                $context[$key] = '***';
            } elseif (is_array($value)) {
                $context[$key] = $this->filterSensitiveRecursive($value);
            }
        }
        return $context;
    }

    /** @param list<string> $sensitiveFields */
    protected static function hideIfHaveSensitiveData(string $message, array $sensitiveFields): string
    {
        foreach ($sensitiveFields as $sensitiveField) {
            if (str_contains($message, $sensitiveField)) {
                return 'String contains sensitive data!';
            }
        }
        return $message;
    }
}
