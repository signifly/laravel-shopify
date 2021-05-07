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

    public static function fromArray(array $data): Shopify
    {
        return new Shopify(
            $data['api_key'],
            $data['password'],
            $data['domain'],
            $data['api_version']
        );
    }
}
