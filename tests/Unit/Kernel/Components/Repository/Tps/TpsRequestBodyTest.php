<?php

namespace Unit\Kernel\Components\Repository\Tps;

use Codeception\Test\Unit;
use Kernel\Components\Repository\Components\Tps\Commands\Commands;
use Kernel\Components\Repository\Components\Tps\Commands\OperationCommands;
use Kernel\Components\Repository\Components\Tps\Commands\ReportCommands;
use Kernel\Components\Repository\Components\Tps\Packages\Command;
use Kernel\Components\Repository\Components\Tps\Packages\Operation;
use Kernel\Components\Repository\Components\Tps\Packages\Report;
use Kernel\Components\Repository\Components\Tps\TpsRequestBody;

class TpsRequestBodyTest extends Unit
{
	public function testGetPackageClassByCommand()
	{
		$enums = [
			Commands::AUTHENTICATION,
			OperationCommands::BILLING_CHECK_STATUS,
			ReportCommands::GENERAL_SUBJECT_REPORT
		];
		foreach ($enums as $enum) {
			$body = new TpsRequestBody($enum, []);
			$this->validateCommandStructure($enum, $body->getCommonBodyStructure());
		}
	}

	private function validateCommandStructure(mixed $enum, array $result): void
	{
		switch (true) {
			case $enum instanceof Commands:
				$this->assertEquals(Command::COMMAND_PT, $result['pt']);
				$this->assertArrayHasKey('command', $result);
				break;
			case $enum instanceof ReportCommands:
				$this->assertEquals(Report::REPORT_PT, $result['pt']);
				$this->assertArrayHasKey('reportType', $result);
				break;
			case $enum instanceof OperationCommands:
				$this->assertEquals(Operation::OPERATION_PT, $result['pt']);
				$this->assertArrayHasKey('operation', $result);
				break;
		}
	}

	public function testBodyParam()
	{
		$body = new TpsRequestBody(OperationCommands::BILLING_CHECK_STATUS, [
			'testKey' => 'testValue',
			'anotherKey' => 'anotherValue',
			'nullValue' => null
		]);
		$result = $body->getCommonBodyStructure();
		$this->assertArrayHasKey('parameters', $result);
		$this->assertEquals('testValue', $result['parameters']['testKey']);
		$this->assertEquals('anotherValue', $result['parameters']['anotherKey']);
		$this->assertArrayNotHasKey('nullValue', $result['parameters']);
	}
}