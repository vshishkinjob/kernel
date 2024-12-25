<?php

namespace Kernel\Components\Exception;

use InvalidArgumentException;
use Kernel\Components\Logger\KernelLoggerInterface;
use Kernel\Components\Request\HttpRequestProtocols\RequestProtocolInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Interfaces\ErrorHandlerInterface;
use Slim\MiddlewareDispatcher;
use Throwable;
use Tuupola\Middleware\CorsMiddleware;

readonly class ErrorComponent implements ErrorHandlerInterface
{
	public function __construct(
		private App $app,
		private KernelLoggerInterface $logger,
		private RequestProtocolInterface $protocol,
		private CorsMiddleware $cors
	) {
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function __invoke(
		ServerRequestInterface $request,
		Throwable $exception,
		bool $displayErrorDetails,
		bool $logErrors,
		bool $logErrorDetails
	): ResponseInterface {
		$this->logger->addErrorLog($exception);
		$response = $this->createResponseThroughCorsMiddleware($request);
		$response = $this->protocol->createErrorResponse($exception, $response);
		return $response->withHeader('Content-type', 'application/json')
			->withHeader('X-XSS-Protection', '1; mode=block')
			->withHeader('X-Content-Type-Options', 'nosniff')
			->withHeader('X-Frame-Options', 'DENY')
			->withHeader('Strict-Transport-Security', 'max-age=157680000; includeSubDomains');
	}

	//Костыль для протаскивания респонса через CORS. Библиотека может использоваться только как middleware
	private function createResponseThroughCorsMiddleware(ServerRequestInterface $request): ResponseInterface
	{
		$handler = new App($this->app->getResponseFactory());
		$handler->addMiddleware($this->createResponseCreatorMiddleware());
		$handler->addMiddleware($this->cors);
		$dispatcher = new MiddlewareDispatcher($handler);

		return $dispatcher->handle($request);
	}

	private function createResponseCreatorMiddleware(): MiddlewareInterface
	{
		return new class ($this->app->getResponseFactory()) implements MiddlewareInterface {
			public function __construct(private ResponseFactoryInterface $responseFactory)
			{
			}

			public function process(
				ServerRequestInterface $request,
				RequestHandlerInterface $handler
			): ResponseInterface {
				return $this->responseFactory->createResponse();
			}
		};
	}
}
