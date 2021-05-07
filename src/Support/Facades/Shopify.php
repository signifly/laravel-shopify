<?php

namespace Signifly\Shopify\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Shopify extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'shopify';
    }
}
