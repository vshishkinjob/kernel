<?php

namespace Unit\Kernel\Components\Error;

use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use DI\Bridge\Slim\Bridge;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\ErrorComponent;
use Kernel\Components\Exception\Http\ForbiddenException;
use Kernel\Components\Logger\KernelLoggerInterface;
use Kernel\Components\Request\HttpRequestProtocols\AbstractProtocol;
use Kernel\Components\Request\HttpRequestProtocols\JsonRpc;
use Kernel\Components\Request\HttpRequestProtocols\Rest;
use Kernel\Components\Response\HttpResponseCode;
use Kernel\Components\Response\ResponseFactory;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Psr7\Environment;
use Tuupola\Middleware\CorsMiddleware;

class ErrorComponentTest extends Unit
{
	protected function _before()
	{
		ResponseFactory::reset();
	}

	private function getRestProtocol()
	{
		return new Rest($this->getRequest(), new ConfigFile(['sensitiveFields' => ['password']]));
	}

	private function getJsonProtocol()
	{
		return new JsonRpc($this->getRequest(), new ConfigFile(['sensitiveFields' => ['password']]));
	}


	private function getErrorComponent(AbstractProtocol $protocol): ErrorComponent
	{
		$app = Bridge::create();
		return $this->make(ErrorComponent::class, [
			'logger' => $this->makeEmpty(KernelLoggerInterface::class, [
				'addErrorLog' => Expected::once()
			]),
			'protocol' => $protocol,
			'app' => $app,
			'cors' => new CorsMiddleware()
		]);
	}

	private function getRequest(): ServerRequestInterface
	{
		$globals = Environment::mock();
		$_SERVER = $globals + $_SERVER;
		$serverRequestCreator = ServerRequestCreatorFactory::create();
		return $serverRequestCreator->createServerRequestFromGlobals();
	}

	public function testGetJsonResponseError()
	{
		$exception = new ForbiddenException("ERROR_MESSAGE", HttpResponseCode::Forbidden->value,
			additionalData: ['password' => 'some_password']);
		$errorComponent = $this->getErrorComponent($this->getJsonProtocol());
		$response = $errorComponent($this->getRequest(), $exception, false, false, false);
		$response->getBody()->rewind();
		$responseBody = json_decode($response->getBody()->getContents(), true);
		$this->assertEquals("2.0", $responseBody['jsonrpc']);
		$this->assertIsArray($responseBody['error']);
		$this->assertEquals(HttpResponseCode::Forbidden->value, $responseBody['error']['code']);
		$this->assertEquals("ERROR_MESSAGE", $responseBody['error']['message']);
		$this->assertEquals("***", $responseBody['error']['details']['password']);
	}

	public function testGetRestResponseError()
	{
		$errorComponent = $this->getErrorComponent($this->getRestProtocol());
		$exception = new ForbiddenException("ERROR_MESSAGE", HttpResponseCode::Forbidden->value,
			additionalData: ['password' => 'some_password']);
		$response = $errorComponent($this->getRequest(), $exception, false, false, false);
		$response->getBody()->rewind();
		$responseBody = json_decode($response->getBody()->getContents(), true);
		$this->assertIsArray($responseBody['error']);
		$this->assertEquals(HttpResponseCode::Forbidden->value, $responseBody['error']['code']);
		$this->assertEquals("ERROR_MESSAGE", $responseBody['error']['message']);
		$this->assertEquals(HttpResponseCode::Forbidden->value, $response->getStatusCode());
		$this->assertEquals("***", $responseBody['error']['details']['password']);
	}
}
