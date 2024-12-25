<?php

namespace Kernel\Components\Repository\Components\Tps;

use Kernel\Components\Exception\App\AppNotFoundException;
use Kernel\Components\Repository\Components\Tps\Commands\Commands;
use Kernel\Components\Repository\Components\Tps\Commands\OperationCommands;
use Kernel\Components\Repository\Components\Tps\Commands\ReportCommands;
use Kernel\Components\Repository\Components\Tps\Packages\AbstractPackage;
use Kernel\Components\Repository\Components\Tps\Packages\Command;
use Kernel\Components\Repository\Components\Tps\Packages\Operation;
use Kernel\Components\Repository\Components\Tps\Packages\Report;

class TpsRequestBody
{
	private AbstractPackage $package;
	private string $commandType;

	/**
	 * @var array<array-key, mixed>
	 */
	private array $parameters;

	/**
	 * @param array<string, mixed> $rawBody
	 * @throws AppNotFoundException
	 */
	public function __construct(private readonly Commands|OperationCommands|ReportCommands $command, array $rawBody)
	{
		$this->package = $this->getPackageClassByCommand();
		$this->parameters = $this->prepareRequestBody($rawBody);
	}

	/**
	 * @throws AppNotFoundException
	 */
	private function getPackageClassByCommand(): AbstractPackage
	{
		$packages = [
			Operation::class => OperationCommands::cases(),
			Command::class => Commands::cases(),
			Report::class => ReportCommands::cases()
		];

		foreach ($packages as $key => $package) {
			if (in_array($this->command, $package, true)) {
				return new $key();
			}
		}

		throw new AppNotFoundException('Tps repository not found!');
	}

	/**
	 * @param array<array-key, mixed> $bodyParams
	 * @return array<array-key, mixed>
	 */
	private function prepareRequestBody(array $bodyParams): array
	{
		foreach ($bodyParams as $key => $item) {
			if (is_array($item)) {
				$bodyParams[$key] = $this->prepareRequestBody($item);
			} elseif (is_string($key) && $item === null) {
				unset($bodyParams[$key]);
			}
		}

		return $bodyParams;
	}

	/**
	 * @return array{pt:int,upid:int,operation?:int,reportType?:int,command?:int,parameters?:array<array-key, mixed>}
	 */
	public function getCommonBodyStructure(): array
	{
		$commonBodyStructure = [
			'pt' => $this->package->getPt(),
			'upid' => $this->package->getUpid()
		];

		switch ($this->package->getPt()) {
			case 3:
				$this->commandType = 'operation';
				break;
			case 4:
				$this->commandType = 'reportType';
				break;
			default:
				$this->commandType = 'command';
				break;
		}
		$commonBodyStructure[$this->commandType] = $this->command->value;
		if (!empty($this->parameters)) {
			$commonBodyStructure['parameters'] = $this->parameters;
		}
		return $commonBodyStructure;
	}

	/**
	 * @return non-empty-string
	 */
	public function getUrl(): string
	{
		return $this->package->getEndpoint();
	}
}
