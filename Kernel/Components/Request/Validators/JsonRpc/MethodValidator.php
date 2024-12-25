<?php

namespace Kernel\Components\Request\Validators\JsonRpc;

use Kernel\Components\Exception\Http\JsonRpcErrorResponseCode;
use Kernel\Components\Exception\Http\MethodNotAllowedException;
use Kernel\Components\Request\RequestValidatorInterface;
use Psr\Http\Message\ServerRequestInterface;

class MethodValidator implements RequestValidatorInterface
{
	/**
	 * @throws MethodNotAllowedException
	 */
    public function validate(ServerRequestInterface $request): void
    {
        if ($request->getMethod() !== 'POST') {
            throw new MethodNotAllowedException(
                'Request method is not allowed.',
                JsonRpcErrorResponseCode::INVALID_REQUEST->value
            );
        }
    }
}
