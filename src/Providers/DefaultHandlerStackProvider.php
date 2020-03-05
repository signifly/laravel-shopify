<?php

namespace Signifly\Shopify\Laravel\Providers;

use Concat\Http\Middleware\RateLimiter;
use Concat\Http\Middleware\RateLimitProvider;
use GuzzleHttp\HandlerStack;
use Signifly\Shopify\RateLimit\DefaultRateLimitCalculator;

class DefaultHandlerStackProvider implements HandlerStackProviderContract
{
    public function getHandlerStack() : HandlerStack
    {
        $handlerStack = HandlerStack::create();
        $handlerStack->push(new RateLimiter($this->getRateLimitProvider()));

        return $handlerStack;
    }

    public function getRateLimitProvider() : RateLimitProvider
    {
        return new DefaultRateLimitProvider(
            new DefaultRateLimitCalculator(
                config('shopify.rate_limit.buffer'),
                config('shopify.rate_limit.cycle'),
                config('shopify.rate_limit.processes')
            )
        );
    }
}
