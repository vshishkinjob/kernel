<?php

declare(strict_types=1);

namespace Kernel\Components\Exception\TPS;

use Kernel\Components\Exception\App\UndefinedAppException;
use Kernel\Components\Exception\File\FileNotFoundException;

final class TpsExceptionFactory
{
	/** @var list<string> */
	private array $tpsExceptions;
	//todo переделал в статик свойство ради тестов т.к не могу замокировать константу
	private static string $exceptionsFolder = __DIR__ . '/Exceptions';

    /**
     * @throws UndefinedAppException
     */
    public function __construct()
	{
		if (!is_array(scandir(self::$exceptionsFolder))) {
			throw new UndefinedAppException('Не найдены exceptions для TPS!');
		} else {
			$this->tpsExceptions = scandir(self::$exceptionsFolder);
		}
	}

	/**
	 * @throws FileNotFoundException
	 */
	public function getTpsExceptionByCode(int $code): BaseTpsException
	{
		foreach ($this->tpsExceptions as $file) {
			$path = self::$exceptionsFolder . '/' . $file;
			if (!file_exists($path)) {
				throw new FileNotFoundException();
			}
			if (pathinfo($path, PATHINFO_EXTENSION) == 'php') {
				$exception = substr('Kernel\Components\Exception\TPS\Exceptions\\' . $file, 0, -4);
				/** @var BaseTpsException $exception */
				if ((new $exception())->getTpsCode() === $code) {
					return new $exception();
				}
			}
		}
		return new UndefinedTpsException(tpsCode: $code);
	}
}
