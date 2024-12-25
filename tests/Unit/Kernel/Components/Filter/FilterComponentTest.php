<?php

namespace Unit\Kernel\Components\Filter;

use Codeception\Test\Unit;
use Kernel\Components\Filter\FilterComponent;
use Kernel\Components\Filter\FilterInterface;
use Kernel\Components\Request\RoutineInterface;
use Slim\MiddlewareDispatcher;
use function Clue\StreamFilter\fun;

class FilterComponentTest extends Unit
{
	public function testProcess()
	{
		$this->expectExceptionMessage('Эксепшн для проверки выполнения');
		$handler = $this->makeEmpty(MiddlewareDispatcher::class);
		$request = $this->makeEmpty(RoutineInterface::class);
		$filter = $this->makeEmpty(FilterInterface::class, [
			'filter' => function (RoutineInterface $routine) {
				throw new \Exception('Эксепшн для проверки выполнения');
			}
		]);
		$filter = $this->construct(FilterComponent::class, ['filters' => [$filter]]);

		$filter->process($request, $handler);
	}
}