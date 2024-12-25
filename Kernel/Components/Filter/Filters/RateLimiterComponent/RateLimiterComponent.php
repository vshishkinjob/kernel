<?php

namespace Kernel\Components\Filter\Filters\RateLimiterComponent;

use Kernel\Components\Exception\Http\TooManyRequestException;
use Kernel\Components\Filter\FilterInterface;
use Kernel\Components\Repository\Components\Redis\RedisComponent;
use Kernel\Components\Request\RoutineInterface;
use RateLimit\Exception\LimitExceeded;
use RateLimit\Rate;
use RateLimit\RedisRateLimiter;

class RateLimiterComponent implements FilterInterface
{
    /**
     * @var RedisComponent
     */
    private RedisComponent $redisComponent;


    public function __construct(RedisComponent $redisComponent)
    {
        // Todo change RedisComponent on RepositoryComponent
        $this->redisComponent = $redisComponent;
    }


	/**
	 * @throws TooManyRequestException
	 */
    public function filter(RoutineInterface $request): void
    {
        /** @var Rate $rate */
        $rate = Rate::perMinute(60);
        $rateLimiter = new RedisRateLimiter($rate, $this->redisComponent->getClient());
        try {
            $rateLimiter->limit((string)$request->getServerParams()['REMOTE_ADDR']);
        } catch (LimitExceeded $exception) {
            throw new TooManyRequestException();
        }
    }
}
