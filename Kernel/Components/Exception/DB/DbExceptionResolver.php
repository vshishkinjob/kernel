<?php

namespace Kernel\Components\Exception\DB;

use Cycle\Database\Exception\StatementException\ConnectionException;
use Kernel\Components\Exception\DB\Exceptions\ConnectionException as ConnectionExceptionKernel;
use Kernel\Components\Logger\KernelLoggerInterface;
use Throwable;

final class DbExceptionResolver
{
	private static function getDbException(Throwable $exception): BaseDbException
	{
		return match (true) {
			$exception instanceof ConnectionException => new ConnectionExceptionKernel(),
			default => new DbException()
		};
	}

	/**
	 * @throws BaseDbException
	 */
	public static function resolveDbException(Throwable $exception, KernelLoggerInterface $logger): never
	{
		$logger->addErrorLog($exception);
		throw self::getDbException($exception);
	}
}
