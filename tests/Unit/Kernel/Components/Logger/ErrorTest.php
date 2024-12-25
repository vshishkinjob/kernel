<?php

namespace Unit\Kernel\Components\Logger;

use Codeception\Test\Unit;
use DateTime;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\App\GatewayTimeoutException;
use Kernel\Components\Exception\App\NullParamException;
use Kernel\Components\Exception\DB\DbException;
use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Exception\Exception;
use Kernel\Components\Exception\Http\ForbiddenException;
use Kernel\Components\Logger\Monolog;
use Kernel\Components\Request\HttpRequestProtocols\RequestProtocolInterface;
use Kernel\Components\Request\ServerSuperGlobalHelper;
use Kernel\Components\Response\HttpResponseCode;
use Kernel\ValueObjects\AppUniqueId;
use Monolog\Logger;
use Throwable;

class ErrorTest extends Unit
{
	private const FILE = __DIR__ . '/app.log';

	protected function _before()
	{
		unlink(self::FILE);
	}

	public function testLogCreatedSuccessfullyAndSensitiveDataHidden()
	{
		$config = new ConfigFile([
			'log' => [
				'folder' => __DIR__
			],
			'sensitiveFields' => ['password']
		]);
		$uniqueId = new AppUniqueId();
		$logger = new Monolog(
			new Logger('logger'),
			$config,
			$uniqueId,
			$this->makeEmpty(RequestProtocolInterface::class)
		);

		$logger->setLogin('testLogin');
		$exception = new ForbiddenException(
			"SOME_MESSAGE",
			HttpResponseCode::Forbidden->value,
			additionalData: ['additionalData' => ['some value']]
		);

		$exception->setLogData([
			'login' => "SOME_LOGIN",
			'Password' => "SOME_PASSWORD"
		]);

		$logger->addErrorLog($exception);
		$data = explode(PHP_EOL, file_get_contents(self::FILE));
		$this->assertTrue(count($data) > 2);
		$fileData = json_decode(file_get_contents(self::FILE), true);

		$this->assertNotEmpty($fileData['context']);
		$this->assertNotEmpty($fileData['extra']);
		$this->assertEquals(ServerSuperGlobalHelper::getUserHostAddress(), $fileData['extra']['ip']);
		$this->assertEquals($uniqueId->getValue(), $fileData['extra']['sessionKey']);
		$this->assertEquals('testLogin', $fileData['extra']['login']);
		$this->assertEquals('***', $fileData['context']['logData']['Password']);
		$this->assertEquals(ForbiddenException::class, $fileData['context']['exception']['class']);
		$this->assertEquals('SOME_MESSAGE', $fileData['context']['exception']['message']);
		$this->assertNotEmpty($fileData['context']['exception']['trace']);
		$this->assertNotFalse(DateTime::createFromFormat('Y-m-d h:i:s', $fileData['datetime']));
	}

	public function testExceptionsTypes()
	{
		foreach (ErrorLevel::cases() as $type) {
			$config = new ConfigFile([
				'log' => [
					'folder' => __DIR__
				],
				'sensitiveFields' => ['password']
			]);
			$uniqueId = new AppUniqueId();
			$logger = new Monolog(
				new Logger('logger'),
				$config,
				$uniqueId,
				$this->makeEmpty(RequestProtocolInterface::class)
			);

			$logger->setLogin('testLogin');


			$exception = new ForbiddenException(
				"SOME_MESSAGE",
				HttpResponseCode::Forbidden->value,
				additionalData: ['additionalData' => ['some value']]
			);

			$exception->setLogData([
				'login' => "SOME_LOGIN",
				'Password' => "SOME_PASSWORD"
			]);

			$logger->addErrorLog($this->getExceptionWithType($type));
			$fileData = json_decode(file_get_contents(self::FILE), true);
			$this->assertEquals(strtolower($type->name), strtolower($fileData['message']));
			unlink(self::FILE);
		}
	}

	protected function _after()
	{
		unlink(self::FILE);
	}

	private function getExceptionWithType(ErrorLevel $type): Exception
	{
		return new class (type: $type) extends Exception {
			public function __construct(
				private ErrorLevel $type,
				string $message = "Conflict with resource",
				int $code = HttpResponseCode::Conflict->value,
				?Throwable $previous = null,
				array $additionalData = []
			) {
				parent::__construct($message, $code, $previous, $additionalData);
			}

			public function getErrorLevel(): ErrorLevel
			{
				return $this->type;
			}
		};
	}

	public function testAddWarningLog()
	{
		$logData = ['logData'];
		$config = new ConfigFile([
			'log' => [
				'folder' => __DIR__
			],
			'sensitiveFields' => ['password']
		]);
		$uniqueId = new AppUniqueId();
		$logger = new Monolog(
			new Logger('logger'),
			$config,
			$uniqueId,
			$this->makeEmpty(RequestProtocolInterface::class)
		);
		$logger->addWarningLog($logData);
		$fileData = json_decode(file_get_contents(self::FILE), true);
		$this->assertNotEmpty($fileData);
	}

}
