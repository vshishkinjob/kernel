<?php

namespace Unit\Kernel\Components\Method;

use Codeception\Test\Unit;
use DI\Container;
use Kernel\Components\Exception\Http\MethodNotFoundException;
use Kernel\Components\Method\MethodComponent;
use Kernel\Components\Request\RoutineInterface;
use Unit\Kernel\Components\Filter\Access\MockMethods\NoExecuteInterfaceMethod;
use Unit\Kernel\Components\Filter\Access\MockMethods\NoRbacMethod;
use Yiisoft\Validator\ValidationContext;
use Yiisoft\Validator\Validator;

class MethodComponentTest extends Unit
{
    public function testFailIfMethodDoNotExists()
    {
        $methodComponent = $this->make(MethodComponent::class);
        $request = $this->makeEmpty(RoutineInterface::class, [
            'getRequestMethodClassName' => function() {
                return "THIS_IS_NOT_METHOD";
            }
        ]);
        $this->expectException(MethodNotFoundException::class);
        $methodComponent->runMethodFromRequest($request);
    }

    public function testFailIfMethodDoNotImplementExecuteInterface()
    {
        $methodComponent = $this->make(MethodComponent::class);
        $request = $this->makeEmpty(RoutineInterface::class, [
            'getRequestMethodClassName' => function() {
                return NoExecuteInterfaceMethod::class;
            }
        ]);
        $this->expectException(MethodNotFoundException::class);
        $methodComponent->runMethodFromRequest($request);
    }

    public function testMethodSuccessfullyRun()
    {
        $methodComponent = $this->make(MethodComponent::class, [
            'container' => new Container(),
            'validator' => new Validator(),
            'context' => new ValidationContext()
        ]);
        $request = $this->makeEmpty(RoutineInterface::class, [
            'getRequestMethodClassName' => function() {
                return NoRbacMethod::class;
            }
        ]);
        $this->assertTrue($methodComponent->runMethodFromRequest($request));
    }
}
