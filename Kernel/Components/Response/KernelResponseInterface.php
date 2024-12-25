<?php

namespace Kernel\Components\Response;

use Kernel\Components\Request\RoutineInterface;
use Psr\Http\Message\ResponseInterface;

interface KernelResponseInterface
{
    /**
     * @param mixed $responseData
     */
    public function response(mixed $responseData, RoutineInterface $request): ResponseInterface;
}
