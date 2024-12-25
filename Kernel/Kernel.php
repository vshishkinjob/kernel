<?php

namespace Kernel;

use DI\Bridge\Slim\Bridge;
use DI\Container;
use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\App\GatewayTimeoutException;
use Kernel\Components\Filter\FilterComponent;
use Kernel\Components\Logger\KernelLoggerInterface;
use Kernel\Components\Request\HttpRequestProtocols\AbstractProtocol;
use Kernel\Components\Request\RequestComponent;
use Kernel\Components\Request\RequestCreatorMiddleware;
use Kernel\Components\Request\RequestValidator;
use Kernel\Components\Sentry;
use Kernel\Components\Session\SessionMiddleware;
use Psr\Http\Server\MiddlewareInterface;
use Slim\App;
use Slim\Interfaces\ErrorHandlerInterface;
use Throwable;
use Tuupola\Middleware\CorsMiddleware;

class Kernel
{
    /**
     * @param array{
     *     apiProtocolClass: class-string<AbstractProtocol>,
     *     sensitiveFields?: list<string>,
     *     sentry: array{dsn: string},
     *     projectUrl?: string,
     *     cacheFolder: string
     * } $config
     * @param array<string, mixed> $appDefinitions
     * @param array<string, mixed> $configDefinitions
     */
    public function run(array $config, array $appDefinitions, array $configDefinitions = []): void
    {
        try {
            Sentry::init($config['sentry']['dsn'], $config['sensitiveFields'] ?? [], $config['projectUrl'] ?? '');
            $this->setShutDownCallback($config['apiProtocolClass'], $config['sensitiveFields'] ?? []);
            $kernelDefinitions = (require_once __DIR__ . '/Definitions/definitions.php')($config);
            $definitions = $appDefinitions + $configDefinitions + $kernelDefinitions;

            $container = $this->buildContainer($definitions, $config);

            /** @var KernelLoggerInterface $logger */
            $logger = $container->get(KernelLoggerInterface::class);
            $this->setWarningLoggingCallback($logger);
            $app = Bridge::create($container);
            $this->setMiddlewares($app, $container);
            $this->setErrorHandler($app, $container);
            $app->run();
        } catch (Throwable $e) {
            if (isset($logger)) {
                $logger->addErrorLog($e);
            } else {
                Sentry::logExceptionToSentry($e);
            }
            /** @var class-string<AbstractProtocol> $protocolClassName */
            $protocolClassName = $config['apiProtocolClass'];
            $protocolClassName::sendRawException($e, $config['sensitiveFields'] ?? []);
        }
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function setMiddlewares(App $app, Container $container): void
    {
        /** @var ConfigFile $config */
        $config = $container->get(ConfigFile::class);
        /**
         * @var list<class-string<MiddlewareInterface>> $additionalMiddlewares
         */
        $additionalMiddlewares = $config->getConfigByKey('additionalMiddlewares') ?? [];

        $middlewareComponents = array_merge(
            [
                RequestComponent::class
            ],
            $additionalMiddlewares,
            [
                FilterComponent::class,
                SessionMiddleware::class,
                RequestCreatorMiddleware::class,
                RequestValidator::class,
                CorsMiddleware::class
            ]
        );

        foreach ($middlewareComponents as $middlewareNamespace) {
            /**
             * @var MiddlewareInterface $middleware
             */
            $middleware = $container->get($middlewareNamespace);
            $app->addMiddleware($middleware);
        }
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function setErrorHandler(App $app, Container $container): void
    {
        $errorMiddleware = $app->addErrorMiddleware(true, true, true);
        /**
         * @var ErrorHandlerInterface $errorHandler
         */
        $errorHandler = $container->get(ErrorHandlerInterface::class);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);
    }

    /**
     * @param class-string<AbstractProtocol> $protocolClassName
     * @param list<string> $sensitiveFields
     */
    private function setShutDownCallback(string $protocolClassName, array $sensitiveFields): void
    {
        register_shutdown_function(function () use ($protocolClassName, $sensitiveFields) {
            $lastError = error_get_last();
            if ($lastError === null) {
                return;
            }
            if (str_contains($lastError['message'], 'Maximum execution time')) {
                ob_clean();
                $error = new GatewayTimeoutException("App running takes too long time!");
                Sentry::logExceptionToSentry($error);
                $protocolClassName::sendRawException($error, $sensitiveFields);
            }
        });
    }

    private function setWarningLoggingCallback(KernelLoggerInterface $logger): void
    {
        /** @phan-suppress PhanUnusedClosureParameter */
        set_error_handler(function (
            int $type,
            string $message,
            string $file = '',
            int $line = 0,
            array $context = []
        ) use ($logger): bool {
            $logger->addWarningLog([
                'message' => $message,
                'file' => $file,
                'line' => $line,
                'context' => $context
            ]);
            return true;
        }, E_WARNING);
    }

    /**
     * @param array{
     *      apiProtocolClass: class-string<AbstractProtocol>,
     *      sensitiveFields?: list<string>,
     *      sentry: array{dsn: string},
     *      projectUrl?: string,
     *      cacheFolder: string
     *  } $config
     * @param array<string, mixed> $definitions
     * @throws Exception
     */
    private function buildContainer(array $definitions, array $config): Container
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions($definitions);
        $builder->enableCompilation($config['cacheFolder']);

        return $builder->build();
    }
}
