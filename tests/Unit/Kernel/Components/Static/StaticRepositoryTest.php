<?php

namespace Unit\Kernel\Components\Static;

use Codeception\Test\Unit;
use Kernel\Components\Config\ConfigFile;
use Kernel\Components\Exception\App\EmptyDataException;
use Kernel\Components\Exception\SSH\ConnectionFailedSSHException;
use Kernel\Components\File\UploadFile\KernelUploadedFileInterface;
use Kernel\Components\Static\StaticRepository;
use Kernel\Definitions\StaticConfig;

class StaticRepositoryTest extends Unit
{

	public function testOnEmptyFilesData()
	{
		$this->expectException(EmptyDataException::class);
		$configFile = new ConfigFile([
			'static' => [
				'host' => 'wrong host',
				'port' => 9999
			]
		]);
		$configFile = new StaticConfig($configFile);
		$staticRepository = $this->construct(StaticRepository::class, ['config' => $configFile]);
		$staticRepository->uploadRawFiles([], 'wrong folder');
	}

	public function testFailedConnection()
	{
		$this->expectException(ConnectionFailedSSHException::class);
		$configFile = new ConfigFile([
			'static' => [
				'host' => 'wrong host',
				'port' => 9999
			]
		]);
		$configFile = new StaticConfig($configFile);
		$staticRepository = $this->construct(StaticRepository::class, ['config' => $configFile]);
		$staticRepository->uploadRawFiles([$this->makeEmpty(KernelUploadedFileInterface::class)], 'wrong folder');
	}
}