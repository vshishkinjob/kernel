<?php

namespace Kernel\Components\Request\Validators\Rest;

use Kernel\Components\Exception\Http\BadRequestException;
use Kernel\Components\Request\RequestValidatorInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

class ContentTypeValidator implements RequestValidatorInterface
{
	/**
	 * @throws BadRequestException
	 * @throws RuntimeException
	 */
    public function validate(ServerRequestInterface $request): void
    {
        $contentType = $request->getHeader('content-type')[0];
        if ($contentType !== 'application/json' && !str_starts_with($contentType, 'multipart/form-data')) {
            throw new BadRequestException('Invalid content-type!. Supported content-type: application/json, multipart/form-data');
        }
    }
}
