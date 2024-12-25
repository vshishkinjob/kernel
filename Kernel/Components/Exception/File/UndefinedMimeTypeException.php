<?php

namespace Kernel\Components\Exception\File;

use Kernel\Components\Exception\ErrorLevel;
use Kernel\Components\Response\HttpResponseCode;
use Throwable;

class UndefinedMimeTypeException extends BaseFileException
{
	public function __construct(
		string $message = "Undefined mime type",
		int $code = HttpResponseCode::InternalServerError->value,
		?Throwable $previous = null,
		array $additionalData = []
	) {
		parent::__construct($message, $code, $previous, $additionalData);
	}

	public function getErrorLevel(): ErrorLevel
	{
		return ErrorLevel::ERROR;
	}
}
