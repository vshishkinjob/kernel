<?php

namespace Unit\Kernel\Components\Repository\Tps;

use Codeception\Stub;
use Codeception\Test\Unit;
use Exception;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use Kernel\Components\Client\AppClientInterface;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\App\GatewayTimeoutException;
use Kernel\Components\Exception\TPS\Exceptions\UnknownErrorTpsException;
use Kernel\Components\Exception\TPS\BaseTpsException;
use Kernel\Components\Repository\Components\Tps\Commands\Commands;
use Kernel\Components\Repository\Components\Tps\Commands\ReportCommands;
use Kernel\Components\Repository\Components\Tps\Packages\Command;
use Kernel\Components\Repository\Components\Tps\Packages\Report;
use Kernel\Components\Repository\Components\Tps\TpsHeaders;
use Kernel\Components\Repository\Components\Tps\TpsInterface;
use Kernel\Components\Repository\Components\Tps\TpsRepository;
use Kernel\Enums\User\SubjectType;
use Kernel\ValueObjects\AppUniqueId;
use Kernel\ValueObjects\Token;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class TpsRepositoryTest extends Unit
{
    private TpsRepository $tpsRepository;
    private array $requestData;
    private string $testUri = "http://tps:8080";
    private string $testToken = 'test';

	/**
	 * @throws Exception
	 */
	protected function _before(): void
	{
		$stream = $this->makeEmpty(StreamInterface::class, [
			'getContents' => json_encode([
				'responseData' => true
			])
		]);

		$response = $this->makeEmpty(ResponseInterface::class, [
			'getBody' => $stream
		]);

		$client = $this->makeEmpty(AppClientInterface::class, [
			'sendRequest' => function (string $method, string $uri, array $options) use ($response) {
				$this->requestData = [
					'method' => $method,
					'uri' => $uri,
					'options' => $options
				];
				return $response;
			}
		]);

		$config = $this->make(ConfigFile::class, [
			'configs' => [
				'tps' => [
					'host' => $this->testUri
				]
			]
		]);
		$headers = new TpsHeaders(
			token: new Token($this->testToken),
			uniqueId: new AppUniqueId()
		);

		$this->tpsRepository = new TpsRepository($config, $client, $headers);
	}


	/**
	 * @throws GuzzleException
	 */
	public function testSuccess()
	{
		$repository = $this->makeEmpty(TpsInterface::class, [
			'getCommand' => Commands::GET_CURRENT_SUBJECT_DATA,
			'getRequestBody' => [
				'testParams' => 'test'
			],
			'getRequestHeaders' => [
				'application' => 'spp/test'
			]
		]);

		$result = $this->tpsRepository->resolve($repository);

		$this->checkResult($result);

		$json = $this->requestData['options']['json'];
		$headers = $this->requestData['options']['headers'];

		$this->assertNotEmpty($json['command']);
		$this->assertNotEmpty($json['parameters']);
		$this->assertNotEmpty($headers);
		$this->assertNotEmpty($headers['application']);
		$this->assertNotEmpty($headers['secret-key']);


		$this->assertEquals($this->testUri . Command::COMMAND_URL, $this->requestData['uri']);
		$this->assertEquals(0, $json['upid']);
		$this->assertEquals(2, $json['pt']);
		$this->assertEquals(Commands::GET_CURRENT_SUBJECT_DATA->value, $json['command']);
		$this->assertEquals(['testParams' => 'test'], $json['parameters']);
		$this->assertEquals('spp/test', $headers['application']);
		$this->assertEquals($this->testToken, $headers['secret-key']);
	}

	public function testSuccessWithReportType()
	{
		$repository = $this->makeEmpty(TpsInterface::class, [
			'getCommand' => ReportCommands::ACCOUNT_MANAGER_MERCHANTS_REPORT,
			'getRequestBody' => [
				'testParams' => 'test'
			],
			'getRequestHeaders' => [
				'application' => 'spp/test'
			]
		]);

		$result = $this->tpsRepository->resolve($repository);

		$this->checkResult($result);

		$json = $this->requestData['options']['json'];
		$headers = $this->requestData['options']['headers'];

		$this->assertNotEmpty($json['reportType']);
		$this->assertNotEmpty($json['parameters']);
		$this->assertNotEmpty($headers);
		$this->assertNotEmpty($headers['application']);
		$this->assertNotEmpty($headers['secret-key']);


		$this->assertEquals($this->testUri . Report::REPORT_URL, $this->requestData['uri']);
		$this->assertEquals(0, $json['upid']);
		$this->assertEquals(4, $json['pt']);
		$this->assertEquals(ReportCommands::ACCOUNT_MANAGER_MERCHANTS_REPORT->value, $json['reportType']);
		$this->assertEquals(['testParams' => 'test'], $json['parameters']);
		$this->assertEquals('spp/test', $headers['application']);
		$this->assertEquals($this->testToken, $headers['secret-key']);
	}

	public function testFailRequest()
	{
		$stream = $this->makeEmpty(StreamInterface::class, [
			'getContents' => json_encode([
				'errorCode' => '1'
			])
		]);

		$response = $this->makeEmpty(ResponseInterface::class, [
			'getBody' => $stream
		]);

		$client = $this->makeEmpty(AppClientInterface::class, [
			'sendRequest' => $response
		]);

		$config = $this->make(ConfigFile::class, [
			'configs' => [
				'tps' => [
					'host' => $this->testUri
				]
			]
		]);
		$headers = new TpsHeaders(
			token: new Token($this->testToken),
			uniqueId: new AppUniqueId()
		);

		$this->tpsRepository = new TpsRepository($config, $client, $headers);

		$repository = $this->makeEmpty(TpsInterface::class, [
			'getCommand' => Commands::GET_CURRENT_SUBJECT_DATA,
			'getRequestBody' => [
				'testParams' => 'test'
			],
			'getRequestHeaders' => [
				'application' => 'spp/test'
			]
		]);

		try {
			$this->tpsRepository->resolve($repository);
		} catch (\Throwable $exception) {
			$this->assertInstanceOf(UnknownErrorTpsException::class, $exception);
			$this->assertEquals(1, $exception->getCode());
			$this->assertEquals(1, $exception->getTpsCode());
			$this->assertEquals("Unknown error", $exception->getMessage());
			$this->assertNull($exception::redefinedTpsCode());
            $logData = $exception->getLogData();
            $this->assertEquals('/wooppay-command/command', $logData['tpsRequest']['url']);
            $this->assertEquals('test', $logData['tpsRequest']['json']['parameters']['testParams']);
            return;
		}
        $this->fail();
	}

	public function testTypeCastWillSuccessful()
	{
		$data = [
			'dateField' => "2023-11-13 11:52:13",
			'stringField' => 'SOME_STRING',
			'single_name' => 13,
			'multiple_name' => [12],
			'enumType' => SubjectType::MERCHANT->value,
		];

		$objects = $this->tpsRepository->convertToObject(
			[$data, $data],
			TypeCastEntity::class
		);
		$this->assertCount(2, $objects);
		$object = $objects[0];
		$this->assertInstanceOf(TypeCastEntity::class, $object);
		$this->assertEquals("2023-11-13 11:52:13", $object->getDateField()->format("Y-m-d H:i:s"));
		$this->assertEquals("SOME_STRING", $object->getStringField());
		$this->assertEquals(13, $object->getSingleName());
		$this->assertEquals([12], $object->getMultipleName());
		$this->assertEquals(SubjectType::MERCHANT, $object->getEnumType());
	}

	private function checkResult(array $result): void
	{
		$this->assertNotEmpty($result);
		$this->assertIsArray($result);
		$this->assertTrue($result[0]);

		$this->assertNotEmpty($this->requestData);
		$this->assertNotEmpty($this->requestData['uri']);
		$this->assertNotEmpty($this->requestData['options']);

		$this->assertNotEmpty($this->requestData['options']['json']);
		$this->assertNotEmpty($this->requestData['options']['json']['pt']);
		$this->assertTrue(isset($this->requestData['options']['json']['upid']));
	}

    public function testGuzzleConnectionException()
    {
        $stream = $this->makeEmpty(StreamInterface::class, [
            'getContents' => json_encode([
                'responseData' => [
                    'test' => true
                ]
            ])
        ]);

        $response = $this->makeEmpty(ResponseInterface::class, [
            'getBody' => $stream
        ]);

        $client = $this->makeEmpty(AppClientInterface::class, [
            'sendRequest' => function() {
                throw new ConnectException('message', $this->makeEmpty(RequestInterface::class));
            }
        ]);

        $config = $this->make(ConfigFile::class, [
            'configs' => [
                'tps' => [
                    'host' => $this->testUri
                ]
            ]
        ]);
        $headers = new TpsHeaders(
            token: new Token($this->testToken),
            uniqueId: new AppUniqueId()
        );

        $repository = $this->makeEmpty(TpsInterface::class, [
            'getCommand' => ReportCommands::ACCOUNT_MANAGER_MERCHANTS_REPORT,
            'getRequestBody' => [
                'testParams' => 'test'
            ],
            'getRequestHeaders' => [
                'application' => 'spp/test'
            ]
        ]);

        $this->expectException(GatewayTimeoutException::class);
        (new TpsRepository($config, $client, $headers))->resolve($repository);
    }
}
