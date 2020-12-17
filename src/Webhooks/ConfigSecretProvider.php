<?php

namespace Signifly\Shopify\Webhooks;

class ConfigSecretProvider implements SecretProvider
{
    public function getSecret(string $domain): string
    {
        return config('shopify.webhooks.secret');
    }
}
