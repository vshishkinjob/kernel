<?php

use DI\Definition\Reference;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Kernel\Components\Client\AppClientInterface;
use Kernel\Components\Client\GuzzleClient;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\ErrorComponent;
use Kernel\Components\File\Excel\ExcelBook\config\ExcelConfigurator;
use Kernel\Components\File\ViewRenderer;
use Kernel\Components\File\ViewRendererInterface;
use Kernel\Components\Filter\FilterComponent;
use Kernel\Components\Filter\Filters\AccessComponent\AccessComponent;
use Kernel\Components\Logger\KernelLoggerInterface;
use Kernel\Components\Logger\Monolog;
use Kernel\Components\Mailer\AppMailerInterface;
use Kernel\Components\Mailer\SymfonyAppMailer;
use Kernel\Components\Method\MethodComponent;
use Kernel\Components\Method\MethodComponentInterface;
use Kernel\Components\Repository\Components\DB\AbstractDbRepository;
use Kernel\Components\Repository\Components\DB\Orm\Cycle;
use Kernel\Components\Repository\Components\Redis\RedisComponent;
use Kernel\Components\Repository\Components\Tps\TpsRepository;
use Kernel\Components\Request\HttpRequestProtocols\RequestProtocolInterface;
use Kernel\Components\Request\RequestCreatorMiddleware;
use Kernel\Components\Request\RequestValidatorInterface;
use Kernel\Components\Request\RequestValidator;
use Kernel\Components\Response\KernelResponseInterface;
use Kernel\Components\Response\ResponseComponent;
use Kernel\Components\Socket\SocketInterface;
use Kernel\Components\Socket\SocketRepository;
use Kernel\Components\Static\StaticInterface;
use Kernel\Components\Static\StaticRepository;
use Kernel\Definitions\DbConfig;
use Kernel\Definitions\interfaces\DbConfigInterface;
use Kernel\Repositories\Interfaces\IdentityInterface;
use Kernel\Repositories\Tps\GetCurrentSubjectDataRepository;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\SimpleCache\CacheInterface;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Interfaces\ErrorHandlerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\SendmailTransport;
use Tuupola\Middleware\CorsMiddleware;
use Yiisoft\Session\Session;
use Yiisoft\Session\SessionInterface;
use Yiisoft\Validator\RuleHandlerResolver\RuleHandlerContainer;
use Yiisoft\Validator\ValidationContext;
use Yiisoft\Validator\Validator as YiiValidator;

use function DI\autowire;
use function DI\create;
use function DI\factory;
use function DI\get;

return function (array $config) {
    /**
     * @var array{
     *    apiProtocolClass: class-string<RequestProtocolInterface>,
     *    cors: array<string, mixed>,
     *    requestValidators: list<class-string<RequestValidatorInterface>>,
     *    cacheFolder: string
     * } $config
     */
    return [
        ServerRequestInterface::class => factory(function () {
            return ServerRequestCreatorFactory::create()->createServerRequestFromGlobals();
        }),
        ExcelConfigurator::class => autowire()->constructor(config: get(ConfigFile::class)),
        ConfigFile::class => autowire()->constructor(configs: $config),
        Logger::class => autowire()->constructorParameter('name', 'logger'),
        KernelLoggerInterface::class => autowire(Monolog::class)->constructor(config: get(ConfigFile::class)),
        RequestValidator::class => create()->constructor(
            validators: []
        ),
        MethodComponentInterface::class => autowire(MethodComponent::class),
        KernelResponseInterface::class => autowire(ResponseComponent::class),
        ErrorHandlerInterface::class => autowire(ErrorComponent::class),
        FilterComponent::class => DI\create(FilterComponent::class)->constructor(filters: [
            //DI\get(RateLimiterComponent::class),
            DI\get(AccessComponent::class)
        ]),
        RedisComponent::class => DI\create()->constructor(config: get(ConfigFile::class)),
        AbstractDbRepository::class => autowire(Cycle::class),
        DbConfigInterface::class => DI\create(DbConfig::class)->constructor(config: get(ConfigFile::class)),
        TpsRepository::class => DI\autowire(TpsRepository::class)->constructor(
            config: get(ConfigFile::class)
        ),
        IdentityInterface::class => autowire(GetCurrentSubjectDataRepository::class),
        ViewRendererInterface::class => autowire(ViewRenderer::class),
        AppMailerInterface::class => autowire(SymfonyAppMailer::class),
        MailerInterface::class => autowire(Mailer::class)->constructor(
            transport: create(SendmailTransport::class)->constructor(command: '/usr/sbin/s -t')
        ),
        ClientInterface::class => create(Client::class),
        AppClientInterface::class => autowire(GuzzleClient::class),
        StaticInterface::class => autowire(StaticRepository::class),
        RequestCreatorMiddleware::class => autowire(RequestCreatorMiddleware::class),
        RequestProtocolInterface::class => autowire($config['apiProtocolClass']),
        CorsMiddleware::class => autowire()->constructorParameter('options', $config['cors']),
        SessionInterface::class => autowire(Session::class)->constructor(),
        YiiValidator::class => autowire()->constructor(
            ruleHandlerResolver: create(RuleHandlerContainer::class)
                ->constructor(container: get(ContainerInterface::class))
        ),
        ValidationContext::class => autowire()->constructor(
            parameters: [ContainerInterface::class => get(ContainerInterface::class)]
        ),
        SocketInterface::class => autowire(SocketRepository::class),
        CacheInterface::class => autowire(Psr16Cache::class)
            ->constructor(pool: get(FilesystemAdapter::class)),
        FilesystemAdapter::class => autowire(FilesystemAdapter::class)->constructor(directory: $config['cacheFolder'])
    ];
};
