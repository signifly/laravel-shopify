<?php

namespace Signifly\Shopify\Webhooks\SecretProviders;

class ConfigSecretProvider implements SecretProviderContract
{
    public function getSecret(string $domain) : string
    {
        return config('shopify.webhook_secret');
    }
}
