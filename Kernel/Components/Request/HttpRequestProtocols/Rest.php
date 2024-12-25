<?php

declare(strict_types=1);

namespace Kernel\Components\Request\HttpRequestProtocols;

use Exception;
use InvalidArgumentException;
use JsonException;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\Exception as BaseKernelException;
use Kernel\Components\Exception\Http\MethodNotFoundException;
use Kernel\Components\Method\ExecuteInterface;
use Kernel\Components\Response\HttpResponseCode;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use RuntimeException;
use Throwable;

class Rest extends AbstractProtocol
{
	public function __construct(
        private readonly ServerRequestInterface $request,
        ConfigFile $configFile,
        /** @var array<string,mixed> $params */
		private array $params = [],
		private string $method = '',
		/** @var array<string, UploadedFileInterface|list<UploadedFileInterface>> $uploadedFiles */
		private array $uploadedFiles = []
	) {
        parent::__construct($configFile);
	}

	/**
	 * @throws RuntimeException
	 */
	public function init(): self
	{
		$this->setProperties();
		return $this;
	}

	/**
	 * @throws RuntimeException
	 */
	private function setProperties(): void
	{
        /** @var array<string, mixed> $params */
        $params = (array)json_decode($this->request->getBody()->getContents(), true);
        /** @var array<string, string> $postParams */
        $postParams = $_POST;
        $this->params = $params + $postParams;
        $this->method = $this->request->getUri()->getPath();

        /** @var array<string, UploadedFileInterface|list<UploadedFileInterface>> $files */
        $files = $this->request->getUploadedFiles();
        $this->uploadedFiles = $files;
	}

	private function convertToCamelCaseAndCapital(string $string): string
	{
		return str_replace('-', '', ucwords($string, '-'));
	}

	protected function validate(): void
	{
	}

	/**
	 * @return array<string,mixed>
	 */
	public function getMethodParams(): array
	{
		return $this->params;
	}

	/**
	 * @throws MethodNotFoundException
	 */
	public function getMethodClassName(): string
	{
		$uri = $this->method;
		if (empty($uri) || $uri === '/') {
			throw new MethodNotFoundException('Url не содержит информации о методе!');
		}

		$paths = explode('/', trim($uri, '/'));
		foreach ($paths as $key => $path) {
			$paths[$key] = $this->convertToCamelCaseAndCapital($path);
		}

		$method = array_pop($paths);
		$module = implode('\\', $paths);

		/** @var class-string<ExecuteInterface> $methodClassName */
		$methodClassName = 'App\\Modules\\' . $module . '\Methods\\' . $method;
		return $methodClassName;
	}

	/**
	 * @throws RuntimeException
	 * @throws JsonException|Exception
	 */
	public function createResponse(ResponseInterface $response, mixed $responseData): ResponseInterface
	{
		$responseJson = json_encode($responseData, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        if ($response->getBody()->isWritable()) {
            $response->getBody()->write($responseJson);
        }
        if (empty($response->getHeader('content-type'))) {
            $response = $response->withHeader('content-type', 'application/json');
        }
		return $response;
	}

	public function getUploadedFiles(): array
	{
		return $this->uploadedFiles;
	}

	/**
	 * @throws RuntimeException
	 * @throws InvalidArgumentException
	 */
	public function createErrorResponse(
		Throwable $exception,
		ResponseInterface $response
	): ResponseInterface {
		$data = [
			'error' => [
				'message' => htmlspecialchars($exception->getMessage()),
				'code' => $exception->getCode(),
			]
		];

        if ($exception instanceof BaseKernelException) {
            $response = $response->withStatus($exception->getHttpStatusCode());
            if (!empty($exception->getAdditionalData())) {
                $data['error']['details'] = $exception->getAdditionalData();
            }
        } else {
            $response = $response->withStatus($this->getHttpCode($exception->getCode()));
        }

		$response->getBody()->write((string)json_encode($this->filterSensitiveRecursive($data)));
		return $response;
	}

    public function getRawMethod(): string
    {
        return (string) $this->request->getUri();
    }

	/**
	 * @throws RuntimeException
	 */
    public function getRawParams(): array
    {
        return (array) (json_decode($this->request->getBody()->getContents(), true) ?? []);
    }

    /**
     * @phan-suppress PhanPluginComparisonNotStrictInCall
     */
    private function getHttpCode(int|string $code): int
    {
        if (in_array($code, HttpResponseCode::getValuesAsArray())) {
            return (int)$code;
        }
        return HttpResponseCode::InternalServerError->value;
    }

    /** @phan-suppress PhanPartialTypeMismatchArgumentInternal */
    public static function sendRawException(Throwable $e, array $sensitiveFields): void
    {
        http_response_code(HttpResponseCode::InternalServerError->value);
        $data = [
            'error' => [
                'message' => htmlspecialchars(self::hideIfHaveSensitiveData($e->getMessage(), $sensitiveFields))
            ]
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
}
