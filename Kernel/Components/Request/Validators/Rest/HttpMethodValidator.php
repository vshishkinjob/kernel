<?php

namespace Kernel\Components\Request\Validators\Rest;

use Kernel\Components\Exception\Http\MethodNotAllowedException;
use Kernel\Components\Request\RequestValidatorInterface;
use Psr\Http\Message\ServerRequestInterface;

class HttpMethodValidator implements RequestValidatorInterface
{
	/**
	 * @throws MethodNotAllowedException
	 */
    public function validate(ServerRequestInterface $request): void
    {
        if (!in_array($request->getMethod(), HttpMethod::getValuesAsArray(), true)) {
            throw new MethodNotAllowedException();
        }
    }
}
