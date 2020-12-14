<?php

namespace Signifly\Shopify\Webhooks;

class ConfigSecretProvider implements SecretProvider
{
    public function getSecret(): string
    {
        return config('shopify.webhooks.secret');
    }
}
