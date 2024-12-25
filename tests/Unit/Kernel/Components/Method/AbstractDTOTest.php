<?php

namespace Unit\Kernel\Components\Method;

use Codeception\Test\Unit;
use DI\Container;
use Kernel\Components\Exception\App\InvalidReflectionTypeException;
use Kernel\Components\Exception\App\NotValidEntityException;
use Kernel\Components\Exception\Http\BadRequestException;
use Kernel\Components\Exception\Validation\ValidationException;
use Kernel\Components\Request\HttpRequestProtocols\RequestProtocolInterface;
use Kernel\Components\Request\KernelRequest;
use Kernel\Components\Response\HttpResponseCode;
use Kernel\Enums\User\SubjectType;
use Kernel\ValueObjects\Email;
use Psr\Http\Message\UploadedFileInterface;
use Unit\Kernel\Components\Method\MockDTO\CorrectDto;
use Unit\Kernel\Components\Method\MockDTO\IncorrectDto;
use Yiisoft\Validator\RuleHandlerResolver\RuleHandlerContainer;
use Yiisoft\Validator\Validator;

class AbstractDTOTest extends Unit
{
	public function testExtraFieldWillFailValidation()
	{
		$extra = 'extraField';
		$routine = $this->make(KernelRequest::class, [
			'getMethodParams' => function () use ($extra) {
				return [
					'field' => 13,
					$extra => true
				];
			},
			'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
		]);

		$dto = new IncorrectDto();
		$this->expectException(BadRequestException::class);
		$this->expectExceptionMessage("Bad request. Field: $extra do not exists");
		$dto->parseRequestToDto($routine);
	}

	public function testIncorrectFieldWillFailValidation()
	{
		$routine = $this->make(KernelRequest::class, [
			'getMethodParams' => function () {
				return [
					'field' => true,
                    'field2' => 'string'
				];
			},
			'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
		]);

		$dto = new IncorrectDto();
		$dto->setValidator(new Validator());
		try {
			$dto->parseRequestToDto($routine);
		} catch (ValidationException $exception) {
			$this->assertEquals('Значение должно быть целым числом.', $exception->getAdditionalData()[0]['message']);
			$this->assertEquals('field',$exception->getAdditionalData()[0]['attribute']);
            $this->assertEquals('Должно быть булевым значением.', $exception->getAdditionalData()[1]['message']);
            $this->assertEquals('field2',$exception->getAdditionalData()[1]['attribute']);
			return;
		}
		$this->fail();
	}

    /**
     * Если добаляются новые TypeCasts, то нужно их сюда добавить
     */
    public function testSuccessValidation()
    {
        $imageInBase64 = file_get_contents(__DIR__ . '/../File/image.txt');
        $routine = $this->make(KernelRequest::class, [
            'getMethodParams' => function() use ($imageInBase64) {
                return [
                    'field' => 12,
                    'file' => $imageInBase64,
                    'files' => [$imageInBase64, $imageInBase64],
                    'type' => SubjectType::MERCHANT->value,
                    'enumCollection' => [HttpResponseCode::InternalServerError->value, HttpResponseCode::Accepted->value],
                    'email' => "some@email.com",
                    'emailCollection' => ['test@test.test', 'test2@test.text'],
                    'dateRange' => ["dateFrom" => "2023-11-12", "dateTo" => "2023-12-11"],
                    'pagination' => ['limit' => 20, 'offset' => 0]
                ];
            },
            'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
        ]);

		$dto = new CorrectDto();
		$container = new Container();
		$dto->setValidator(new Validator(ruleHandlerResolver: new RuleHandlerContainer($container)));
		$dto->parseRequestToDto($routine);
		$this->assertNotEmpty($dto->file);
		$this->assertCount(2, $dto->files);
		$this->assertEquals(SubjectType::MERCHANT, $dto->type);
		$this->assertInstanceOf(MockEnumCollection::class, $dto->enumCollection);
		$this->assertCount(2, $dto->enumCollection);
        $this->assertInstanceOf(Email::class, $dto->email);
        $this->assertEquals(['test@test.test', 'test2@test.text'], $dto->emailCollection->getAllValues());
        $this->assertEquals('2023-11-12', $dto->dateRange->dateFrom);
        $this->assertEquals(1, $dto->pagination->getPage());
	}

    public function testFilesAddedFromRequest(): void
    {
        $routine = $this->make(KernelRequest::class, [
            'getMethodParams' => function () {
                return [
                    'field' => 13
                ];
            },
            'getProtocol' => $this->makeEmpty(RequestProtocolInterface::class, [
                'getUploadedFiles' => ['file' => $this->makeEmpty(UploadedFileInterface::class)]
            ])
        ]);

        $dto = $this->make(IncorrectDto::class, [
            'validate' => null
        ]);
        $dto->parseRequestToDto($routine);

        $this->assertArrayHasKey('file', $dto->getArrayData());
        $this->assertInstanceOf(UploadedFileInterface::class, $dto->getArrayData()['file']);
    }

    public function testGetArrayData(): void
    {
        $dto = new IncorrectDto();
        $dto->setArrayData([
            'except' => 'EXCEPT',
            'another' => 'ANOTHER'
        ]);
        $dto->setDataByKey('only', 'ONLY');

        $data = $dto->getArrayData(except: ['except'], only: ['only']);
        $this->assertCount(1, $data);
        $this->assertArrayHasKey('only', $data);


        $data = $dto->getArrayData(only: ['only']);
        $this->assertCount(1, $data);
        $this->assertArrayHasKey('only', $data);


        $data = $dto->getArrayData(except: ['except']);
        $this->assertCount(2, $data);
        $this->assertArrayHasKey('only', $data);
        $this->assertArrayHasKey('another', $data);


        $data = $dto->getArrayData();
        $this->assertCount(3, $data);
        $this->assertArrayHasKey('only', $data);
        $this->assertArrayHasKey('another', $data);
        $this->assertArrayHasKey('except', $data);
    }

    public function testUnionType()
    {
        $this->expectException(InvalidReflectionTypeException::class);
        $routine = $this->make(KernelRequest::class, [
            'getMethodParams' => function () {
                return [
                    'unionType' => 'string'
                ];
            },
            'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
        ]);

        $dto = new IncorrectDto();
        $dto->setValidator(new Validator());
        $dto->parseRequestToDto($routine);
    }

    public function testStringConvertionSuccess()
    {
        $routine = $this->make(KernelRequest::class, [
            'getMethodParams' => function () {
                return [
                    'string' => '<some Xss>'
                ];
            },
            'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
        ]);

        $dto = new CorrectDto();
        $dto->setValidator(new Validator());
        $dto->parseRequestToDto($routine);
        $this->assertEquals('&lt;some Xss&gt;', $dto->string);
    }

    public function testStringConvertionFails()
    {
        $this->expectException(NotValidEntityException::class);
        $routine = $this->make(KernelRequest::class, [
            'getMethodParams' => function () {
                return [
                    'notAString' => 13
                ];
            },
            'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
        ]);

        $dto = new IncorrectDto();
        $dto->setValidator(new Validator());
        $dto->parseRequestToDto($routine);
    }

    public function testArrayConvertionSuccess()
    {
        $routine = $this->make(KernelRequest::class, [
            'getMethodParams' => function () {
                return [
                    'array' => ['<some Xss>', '<another Xss>']
                ];
            },
            'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
        ]);

        $dto = new CorrectDto();
        $dto->setValidator(new Validator());
        $dto->parseRequestToDto($routine);
        $this->assertEquals(['&lt;some Xss&gt;', '&lt;another Xss&gt;'], $dto->array);
    }

    public function testArrayConvertionFails()
    {
        $this->expectException(NotValidEntityException::class);
        $routine = $this->make(KernelRequest::class, [
            'getMethodParams' => function () {
                return [
                    'notAnArray' => 13
                ];
            },
            'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
        ]);

        $dto = new IncorrectDto();
        $dto->setValidator(new Validator());
        $dto->parseRequestToDto($routine);
    }

    public function testIntegerStringConvertionSuccess()
    {
        $routine = $this->make(KernelRequest::class, [
            'getMethodParams' => function () {
                return [
                    'integerString' => '13'
                ];
            },
            'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
        ]);

        $dto = new CorrectDto();
        $dto->setValidator(new Validator());
        $dto->parseRequestToDto($routine);
        $this->assertEquals(13, $dto->integerString);
    }

    public function testIntegerStringConvertionFails()
    {
        $this->expectException(NotValidEntityException::class);
        $routine = $this->make(KernelRequest::class, [
            'getMethodParams' => function () {
                return [
                    'notAnIntegerString' => 'STRING'
                ];
            },
            'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
        ]);

        $dto = new IncorrectDto();
        $dto->setValidator(new Validator());
        $dto->parseRequestToDto($routine);
    }

    public function testFloatStringConvertionSuccess()
    {
        $routine = $this->make(KernelRequest::class, [
            'getMethodParams' => function () {
                return [
                    'floatString' => '13.2'
                ];
            },
            'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
        ]);

        $dto = new CorrectDto();
        $dto->setValidator(new Validator());
        $dto->parseRequestToDto($routine);
        $this->assertEquals(13.2, $dto->floatString);
    }

    public function testFloatStringConvertionFails()
    {
        $this->expectException(NotValidEntityException::class);
        $routine = $this->make(KernelRequest::class, [
            'getMethodParams' => function () {
                return [
                    'notAnFloatString' => 'STRING'
                ];
            },
            'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
        ]);

        $dto = new IncorrectDto();
        $dto->setValidator(new Validator());
        $dto->parseRequestToDto($routine);
    }

    public function testBoolConvertionSuccess()
    {
        $routine = $this->make(KernelRequest::class, [
            'getMethodParams' => function () {
                return [
                    'bool' => true
                ];
            },
            'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
        ]);

        $dto = new CorrectDto();
        $dto->setValidator(new Validator());
        $dto->parseRequestToDto($routine);
        $this->assertEquals(true, $dto->bool);
    }

    public function testBoolConvertionFails()
    {
        $this->expectException(NotValidEntityException::class);
        $routine = $this->make(KernelRequest::class, [
            'getMethodParams' => function () {
                return [
                    'notAnBool' => 'STRING'
                ];
            },
            'protocol' => $this->makeEmpty(RequestProtocolInterface::class)
        ]);

        $dto = new IncorrectDto();
        $dto->setValidator(new Validator());
        $dto->parseRequestToDto($routine);
    }
}
