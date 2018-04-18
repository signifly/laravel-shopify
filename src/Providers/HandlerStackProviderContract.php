<?php

namespace Signifly\Shopify\Laravel\Providers;

use GuzzleHttp\HandlerStack;
use Concat\Http\Middleware\RateLimitProvider;

interface HandlerStackProviderContract
{
    public function getHandlerStack() : HandlerStack;

    public function getRateLimitProvider() : RateLimitProvider;
}
