<?php

namespace Kernel\Components\Exception\Socket;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class SocketConnectionException extends BaseSocketException
{
	public function __construct(
		string $message = "socket_connect() failed failed",
		int $code = HttpResponseCode::InternalServerError->value,
		?Throwable $previous = null,
		array $additionalData = []
	) {
		parent::__construct($message, $code, $previous, $additionalData);
	}

	public function getErrorLevel(): ErrorLevel
	{
		return ErrorLevel::CRITICAL;
	}
}
