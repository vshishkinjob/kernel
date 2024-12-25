<?php

namespace Kernel\Components\Request\Validators\JsonRpc;

use Kernel\Components\Exception\Http\BadRequestException;
use Kernel\Components\Exception\Http\JsonRpcErrorResponseCode;
use Kernel\Components\Request\RequestValidatorInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionException;
use RuntimeException;
use Yiisoft\Validator\Rule\Json;
use Yiisoft\Validator\Validator;

class JsonValidator implements RequestValidatorInterface
{
	/**
	 * @throws BadRequestException
	 * @throws ReflectionException
	 * @throws RuntimeException
	 */
    public function validate(ServerRequestInterface $request): void
    {
        $contentType = $request->getHeader('content-type')[0];
        $content = $request->getBody()->getContents();
        $validation = (new Validator())->validate($content, [new Json()]);
        if ($contentType !== 'application/json' || !empty($validation->getErrors())) {
            throw new BadRequestException(
                'Invalid JSON was received by the server.',
                JsonRpcErrorResponseCode::PARSE_ERROR->value
            );
        }
    }
}
