<?php

namespace Signifly\Shopify;

class Factory
{
    public static function fromConfig(): Shopify
    {
        return new Shopify(
            config('shopify.credentials.api_access_token'),
            config('shopify.credentials.domain'),
            config('shopify.credentials.api_version'),
        );
    }

    public static function fromArray(array $data): Shopify
    {
        return new Shopify(
            $data['api_access_token'],
            $data['domain'],
            $data['api_version']
        );
    }
}
