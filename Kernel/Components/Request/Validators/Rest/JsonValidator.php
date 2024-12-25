<?php

namespace Kernel\Components\Request\Validators\Rest;

use Kernel\Components\Exception\Http\BadRequestException;
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
        if ($contentType !== 'application/json') {
            return;
        }
        $content = $request->getBody()->getContents();
        if (empty($content)) {
            return;
        }
        $validation = (new Validator())->validate($content, [new Json()]);
        if (!empty($validation->getErrors())) {
            throw new BadRequestException('Invalid JSON was received by the server.');
        }
    }
}
