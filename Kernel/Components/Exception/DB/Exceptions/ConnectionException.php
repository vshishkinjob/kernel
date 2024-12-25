<?php

namespace Kernel\Components\Exception\DB\Exceptions;

use Kernel\Components\Exception\DB\BaseDbException;
use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class ConnectionException extends BaseDbException
{
	public function __construct(
		string $message = "Db connection unavailable",
		int $code = HttpResponseCode::ServiceUnavailable->value,
		?Throwable $previous = null,
		array $additionalData = []
	) {
		parent::__construct($message, $code, $previous, $additionalData);
	}

	public function getErrorLevel(): ErrorLevel
	{
		return ErrorLevel::EMERGENCY;
	}
}
