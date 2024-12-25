<?php

namespace Unit\Kernel\Components\Filter\RateLimiter;

use Codeception\Attribute\Skip;
use Codeception\Test\Unit;
use Kernel\Components\Filter\FilterInterface;
use Kernel\Components\Filter\Filters\RateLimiterComponent\RateLimiterComponent;
use Kernel\Components\Repository\Components\Redis\RedisComponent;
use Kernel\Components\Request\RoutineInterface;

/**
 * TODO: Добавить тесты
 * юниты для этого компонента не подходят
 */
class RateLimiterTest extends Unit
{
    private FilterInterface $rateLimiter;
    private RoutineInterface $request;

    protected function _before(): void
    {
        $redis = $this->construct(RedisComponent::class);
        $this->rateLimiter = new RateLimiterComponent($redis);
        $this->request = $this->makeEmpty(RoutineInterface::class);
    }
}
