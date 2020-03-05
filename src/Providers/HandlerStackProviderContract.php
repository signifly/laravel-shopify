<?php

namespace Signifly\Shopify\Laravel\Providers;

use Concat\Http\Middleware\RateLimitProvider;
use GuzzleHttp\HandlerStack;

interface HandlerStackProviderContract
{
    public function getHandlerStack(): HandlerStack;

    public function getRateLimitProvider(): RateLimitProvider;
}
