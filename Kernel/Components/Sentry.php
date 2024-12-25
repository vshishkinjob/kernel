<?php

namespace Kernel\Components;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Exception\Exception;
use Kernel\Definitions\Environment;
use Sentry\Severity;
use Sentry\State\Scope;
use Throwable;

/**
 * @infection-ignore-all
 */
final class Sentry
{
    private static Sentry $instance;
    /** @var list<string> $sensitiveFields */
    private static array $sensitiveFields;
    private static string $url;

    /**
     * @param list<string> $sensitiveFields
     */
    private function __construct(string $dsn, array $sensitiveFields, string $url)
    {
        \Sentry\init([
            'dsn' => $dsn,
            'enable_tracing' => true,
            'attach_stacktrace' => true,
            'max_request_body_size' => 'always'
        ]);
        self::$sensitiveFields = $sensitiveFields;
        self::$url = $url;
    }

    /**
     * @param list<string> $sensitiveFields
     */
    public static function init(string $dsn, array $sensitiveFields, string $url): Sentry
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($dsn, $sensitiveFields, $url);
        }

        return self::$instance;
    }

    public static function logExceptionToSentry(Throwable $e): void
    {
        if (!self::isEnabled()) {
            return;
        }
        \Sentry\withScope(function (Scope $scope) use ($e): void {
            $extras = [];
            $extras['request'] = self::hideSensitiveData($_REQUEST);
            if ($e instanceof Exception) {
                if (!ErrorLevel::isInErrorList($e->getErrorLevel())) {
                    return;
                }
                $extras['context'] = self::hideSensitiveData($e->getLogData());
                $scope->setLevel(self::resolveLevel($e->getErrorLevel()));
            } else {
                $scope->setLevel(Severity::fatal());
            }
            $scope->setExtras($extras);
            \Sentry\captureException($e);
        });
    }

    private static function resolveLevel(ErrorLevel $level): Severity
    {
        switch ($level->name) {
            case ErrorLevel::EMERGENCY:
            case ErrorLevel::ALERT:
            case ErrorLevel::CRITICAL:
                return Severity::fatal();
            default:
                return Severity::error();
        }
    }

    /**
     * @param mixed[] $data
     * @return mixed[]
     */
    private static function hideSensitiveData(array $data): array
    {
        $sensitiveFields = self::$sensitiveFields;
        foreach ($data as $key => $value) {
            if (is_string($key) && in_array(strtolower($key), $sensitiveFields, true)) {
                $data[$key] = '***';
            } elseif (is_array($value)) {
                $data[$key] = self::hideSensitiveData($value);
            }
        }
        return $data;
    }

    private static function isEnabled(): bool
    {
        if (ENVIRONMENT === Environment::PROD) {
            return true;
        }
        if (
            ENVIRONMENT === Environment::DEVELOP
            && !empty($_SERVER['SERVER_NAME'])
            && str_contains(self::$url, $_SERVER['SERVER_NAME'])
        ) {
            return true;
        }
        return false;
    }
}
