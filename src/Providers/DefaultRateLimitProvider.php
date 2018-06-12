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
    protected $prefix;

    public function __construct(RateLimitCalculatorContract $calculator, string $prefix = '')
    {
        $this->calculator = $calculator;
        $this->prefix = $prefix;
    }

    /**
     * Returns when the last request was made.
     *
     * @return float|null When the last request was made.
     */
    public function getLastRequestTime()
    {
        return Cache::get($this->prefix . 'last_request_time');
    }

    /**
     * Used to set the current time as the last request time to be queried when
     * the next request is attempted.
     */
    public function setLastRequestTime()
    {
        return Cache::forever($this->prefix . 'last_request_time', microtime(true));
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
        return Cache::get($this->prefix . 'request_allowance', config('shopify.rate_limit.cycle'));
    }

    /**
     * Used to set the minimum amount of time that is required to pass between
     * this request and the next request.
     *
     * @param ResponseInterface $response The resolved response.
     */
    public function setRequestAllowance(ResponseInterface $response)
    {
        Cache::forever($this->prefix . 'request_allowance', $this->calculateAllowanceFrom($response));
    }

    /**
     * Calculate the request allowance from the response.
     *
     * @param  ResponseInterface $response
     * @return float
     */
    protected function calculateAllowanceFrom(ResponseInterface $response)
    {
        $callLimitHeader = collect(
            $response->getHeader('HTTP_X_SHOPIFY_SHOP_API_CALL_LIMIT')
        )->first();

        if ($callLimitHeader) {
            [$callsMade, $callsLimit] = explode('/', $callLimitHeader);
            return $this->calculator->calculate($callsMade, $callsLimit);
        }

        return floatval(
            config('shopify.rate_limit.processes') * config('shopify.rate_limit.cycle')
        );
    }
}
