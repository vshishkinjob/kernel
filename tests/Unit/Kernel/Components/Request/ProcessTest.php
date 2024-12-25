<?php

namespace Unit\Kernel\Components\Request;

use Codeception\Test\Unit;
use Kernel\Components\Method\MethodComponentInterface;
use Kernel\Components\Request\RequestComponent;
use Kernel\Components\Response\KernelResponseInterface;


// компонент у которого нет "своей" логики, по идее, достаточно будет протестировать составляющие его компоненты
// после тестирование составляющих, вернутся и посмотреть что можно сделать.
class ProcessTest extends Unit
{
    private RequestComponent $requestComponent;

    protected function _before(): void
    {
        $methodComponent = $this->makeEmpty(MethodComponentInterface::class);
        $kernelResponse = $this->makeEmpty(KernelResponseInterface::class);

        $this->requestComponent = new RequestComponent(
            $methodComponent,
            $kernelResponse
        );
    }


    public function testProcess()
    {
       // $this->requestComponent->process();
    }

}
