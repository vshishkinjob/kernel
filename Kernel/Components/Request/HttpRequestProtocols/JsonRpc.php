<?php

namespace Kernel\Components\Request\HttpRequestProtocols;

use Exception;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\Exception as BaseKernelException;
use Kernel\Components\Exception\Http\BadRequestException;
use Kernel\Components\Exception\Http\JsonRpcErrorResponseCode;
use Kernel\Components\Method\ExecuteInterface;
use Kernel\Components\Response\HttpResponseCode;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use Throwable;

class JsonRpc extends AbstractProtocol
{
	/**
	 * @param array<string,mixed>|null $params
	 */
	public function __construct(
		private readonly ServerRequestInterface $request,
		ConfigFile $configFile,
		private ?string $jsonrpc = '',
		private ?string $method = '',
		private ?array $params = [],
		private ?int $id = null
	) {
		parent::__construct($configFile);
	}

	/**
	 * @throws BadRequestException
	 * @throws RuntimeException
	 */
	public function init(): self
	{
		$this->setProperties();
		$this->validate();
		return $this;
	}

	/**
	 * @throws BadRequestException
	 * @throws RuntimeException
	 */
	private function setProperties(): void
	{
		$firstOccurrence = strstr(serialize(json_decode($this->request->getBody()->getContents(), true)), ':');
		if ($firstOccurrence === false) {
			throw new BadRequestException(
				'Request params is not valid.',
				JsonRpcErrorResponseCode::INVALID_PARAMS->value
			);
		}
		/** @var JsonRpc $jsonRpcObject */
		$jsonRpcObject = unserialize(
			sprintf(
				'O:%d:"%s"%s',
				strlen(self::class),
				self::class,
				$firstOccurrence
			)
		);
		$this->jsonrpc = $jsonRpcObject->getJsonrpc();
		$this->params = $jsonRpcObject->getParams();
		$this->method = $jsonRpcObject->getMethod();
		$this->id = $jsonRpcObject->getId();
	}

	/**
	 * @throws BadRequestException
	 */
	protected function validate(): void
	{
		if (!$this->isValidData()) {
			throw new BadRequestException(
				'Request params is not valid.',
				JsonRpcErrorResponseCode::INVALID_PARAMS->value
			);
		}
	}

	private function isValidData(): bool
	{
		return $this->jsonrpc === "2.0" && !empty($this->method);
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMethodParams(): array
	{
		return $this->getParams();
	}

	public function getMethodClassName(): string
	{
		$methodData = explode("/", $this->getMethod());
		foreach ($methodData as $key => $part) {
			$methodData[$key] = ucfirst($part);
		}
		$module = $methodData[0];
		unset($methodData[0]);
		$method = implode("\\", $methodData);
		/** @var class-string<ExecuteInterface> $methodClassName */
		$methodClassName = 'App\\Modules\\' . $module . '\Methods\\' . $method;
		return $methodClassName;
	}

	/**
	 * @throws \JsonException
	 * @throws RuntimeException|Exception
	 */
	public function createResponse(ResponseInterface $response, mixed $responseData): ResponseInterface
	{
		$responseArray = [
			'jsonrpc' => '2.0',
			'method' => $this->method,
			'id' => $this->id
		];
		if ($responseData !== null) {
			$responseArray['result'] = $responseData;
		}
		$responseJson = json_encode($this->filterSensitiveRecursive($responseArray), JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
		if ($response->getBody()->isWritable()) {
			$response->getBody()->write($responseJson);
		}
        if (empty($response->getHeader('content-type'))) {
            $response = $response->withHeader('content-type', 'application/json');
        }
		return $response;
	}

	/**
	 * @return string
	 */
	public function getJsonrpc(): string
	{
		return $this->jsonrpc ?? '';
	}

	/**
	 * @return string
	 */
	public function getMethod(): string
	{
		return $this->method ?? '';
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getParams(): array
	{
		return $this->params ?? [];
	}

	/**
	 * @return int|null
	 */
	public function getId(): ?int
	{
		return $this->id ?? null;
	}

	public function getUploadedFiles(): array
	{
		return [];
	}

	/**
	 * @throws RuntimeException
	 */
	public function createErrorResponse(
		Throwable $exception,
		ResponseInterface $response
	): ResponseInterface {
		$data = [
			'jsonrpc' => '2.0',
			'error' => [
				'code' => $exception->getCode(),
				'message' => htmlspecialchars($exception->getMessage()),
			]
		];

		if ($exception instanceof BaseKernelException) {
			$data['error']['details'] = $exception->getAdditionalData();
		}

		$requestId = $this->getRequestId($this->request);
		isset($requestId) ? $data = array_merge($data, ['id' => $requestId]) : null;

		$response->getBody()->write((string)json_encode($this->filterSensitiveRecursive($data)));
		return $response;
	}

	/**
	 * @throws RuntimeException
	 */
	private function getRequestId(ServerRequestInterface $request): ?string
	{
		/**
		 * @var array{jsonrpc?:string, method?:string, id?:string, params?:array<string,mixed>} $requestBody
		 */
		$requestBody = (array)json_decode($request->getBody()->getContents(), true);
		return $requestBody['id'] ?? null;
	}

	/**
	 * @throws RuntimeException
	 */
	public function getRawMethod(): string
	{
        /** @var string $decoded */
        $decoded = json_decode($this->request->getBody()->getContents(), true)['method'] ?? '';
		return $decoded;
	}

	/**
	 * @throws RuntimeException
	 */
	public function getRawParams(): array
	{
		/** @var array{params?: array<array-key, mixed>} $content */
		$content = json_decode($this->request->getBody()->getContents(), true);
		return $content['params'] ?? [];
	}

	public static function sendRawException(Throwable $e, array $sensitiveFields): void
	{
		header('Content-Type: application/json');
        http_response_code(HttpResponseCode::Ok->value);
		$response = [
			'jsonrpc' => '2.0',
			'error' => [
				'code' => $e->getCode(),
				'message' => htmlspecialchars(self::hideIfHaveSensitiveData($e->getMessage(), $sensitiveFields)),
			]
		];
		if ($e instanceof BaseKernelException) {
			$response['error']['details'] = $e->getAdditionalData();
		}
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
}
