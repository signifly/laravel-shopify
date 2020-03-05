<?php

namespace Signifly\Shopify\Laravel\Webhooks\SecretProviders;

class ConfigSecretProvider implements SecretProviderContract
{
    public function getSecret(string $domain): string
    {
        return (string) config('shopify.webhooks.secret');
    }
}
