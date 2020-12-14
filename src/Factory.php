<?php

namespace Signifly\Shopify;

class Factory
{
    public static function fromConfig(): Shopify
    {
        return new Shopify(
            config('shopify.credentials.api_key'),
            config('shopify.credentials.password'),
            config('shopify.credentials.domain'),
            config('shopify.credentials.api_version'),
        );
    }
}
