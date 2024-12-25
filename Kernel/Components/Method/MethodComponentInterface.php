<?php

namespace Kernel\Components\Method;

use Kernel\Components\Request\RoutineInterface;

interface MethodComponentInterface
{
    /**
     * @return mixed
     */
    public function runMethodFromRequest(RoutineInterface $request): mixed;

    /**
     * @param class-string<ExecuteInterface> $className
     * @return ExecuteInterface
     */
    public function getMethodByClassName(string $className): ExecuteInterface;

    public function getMethod(RoutineInterface $request): ExecuteInterface;
}
