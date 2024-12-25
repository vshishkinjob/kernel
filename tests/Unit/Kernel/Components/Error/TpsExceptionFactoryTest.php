<?php

namespace Unit\Kernel\Components\Error;

use Codeception\Test\Unit;
use Kernel\Components\Exception\App\UndefinedAppException;
use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\Exception\TPS\Exceptions\UserNotRegisteredTpsException;
use Kernel\Components\Exception\TPS\TpsExceptionFactory;
use Kernel\Components\Exception\TPS\UndefinedTpsException;

class TpsExceptionFactoryTest extends Unit
{
	public function testTpsExceptionsList()
	{
		$exception = new TpsExceptionFactory();
		$first = $exception->getTpsExceptionByCode(3002);
		$this->assertTrue(get_class($first) == UserNotRegisteredTpsException::class);
		$this->assertEquals('Bad credentials', $first->getMessage());
		$first = $exception->getTpsExceptionByCode(9999999);
		$this->assertTrue(get_class($first) == UndefinedTpsException::class);
	}

	public function testTpsPathString()
	{
		$mock = $this->make(TpsExceptionFactory::class, [
			'tpsExceptions' => ['file not exist']
		]);
		$this->expectException(FileNotFoundException::class);
		$mock->getTpsExceptionByCode(322);
	}

	public function testTpsExceptionsDir()
	{
		$reflectionClass = new \ReflectionClass(TpsExceptionFactory::class);
		$originalProperty = $reflectionClass->getProperty('exceptionsFolder')->getValue($reflectionClass);
		$reflectionClass->setStaticPropertyValue('exceptionsFolder',"not exist folder");
		try {
			$reflectionClass->newInstance();
		} catch (\Throwable $exception){
			$this->assertInstanceOf(UndefinedAppException::class,$exception);
		}
		$reflectionClass->setStaticPropertyValue('exceptionsFolder',$originalProperty);
	}
}