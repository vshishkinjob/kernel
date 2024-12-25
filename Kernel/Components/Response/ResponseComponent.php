<?php

namespace Kernel\Components\Response;

use InvalidArgumentException;
use Kernel\Components\Request\RoutineInterface;
use Psr\Http\Message\ResponseInterface;

class ResponseComponent implements KernelResponseInterface
{
    //TODO: вынести создание хэдеров
	/**
	 * @throws InvalidArgumentException
	 */
    public function response(mixed $responseData, RoutineInterface $request): ResponseInterface
    {
        $response = ResponseFactory::getResponse();
        $psrResponse = $request->getProtocol()->createResponse($response, $responseData);
        return $psrResponse
            ->withHeader('X-XSS-Protection', '1; mode=block')
            ->withHeader('X-Content-Type-Options', 'nosniff')
            ->withHeader('X-Frame-Options', 'DENY')
            ->withHeader('Strict-Transport-Security', 'max-age=157680000; includeSubDomains');
    }
}
