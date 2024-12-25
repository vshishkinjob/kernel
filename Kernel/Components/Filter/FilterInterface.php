<?php

namespace Kernel\Components\Filter;

use Kernel\Components\Request\RoutineInterface;

interface FilterInterface
{
    public function filter(RoutineInterface $request): void;
}
