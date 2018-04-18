<?php

namespace Signifly\Shopify\Laravel\Providers;

use Illuminate\Support\Facades\Cache;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Concat\Http\Middleware\RateLimitProvider;
use Signifly\Shopify\RateLimit\RateLimitCalculatorContract;

class DefaultRateLimitProvider implements RateLimitProvider
{
    protected $calculator;

    public function __construct(RateLimitCalculatorContract $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Returns when the last request was made.
     *
     * @return float|null When the last request was made.
     */
    public function getLastRequestTime()
    {
        return Cache::get('last_request_time');
    }

    /**
     * Used to set the current time as the last request time to be queried when
     * the next request is attempted.
     */
    public function setLastRequestTime()
    {
        return Cache::forever('last_request_time', microtime(true));
    }

    /**
     * Returns what is considered the time when a given request is being made.
     *
     * @param RequestInterface $request The request being made.
     *
     * @return float Time when the given request is being made.
     */
    public function getRequestTime(RequestInterface $request)
    {
        return microtime(true);
    }

    /**
     * Returns the minimum amount of time that is required to have passed since
     * the last request was made. This value is used to determine if the current
     * request should be delayed, based on when the last request was made.
     *
     * Returns the allowed time between the last request and the next, which
     * is used to determine if a request should be delayed and by how much.
     *
     * @param RequestInterface $request The pending request.
     *
     * @return float The minimum amount of time that is required to have passed
     *               since the last request was made (in seconds).
     */
    public function getRequestAllowance(RequestInterface $request)
    {
        return Cache::get('request_allowance', 0.5);
    }

    /**
     * Used to set the minimum amount of time that is required to pass between
     * this request and the next request.
     *
     * @param ResponseInterface $response The resolved response.
     */
    public function setRequestAllowance(ResponseInterface $response)
    {
        Cache::forever('request_allowance', $this->calculator->calculate());
    }
}
