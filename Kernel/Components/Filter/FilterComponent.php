<?php

namespace Kernel\Components\Filter;

use Kernel\Components\Request\RoutineInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FilterComponent implements MiddlewareInterface
{
    /**
     * @var FilterInterface[]
     */
    private array $filters;

    /**
     * FilterComponent constructor.
     * @param FilterInterface[] $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @param RoutineInterface $request
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        foreach ($this->filters as $filter) {
            $filter->filter($request);
        }

        return $handler->handle($request);
    }
}
