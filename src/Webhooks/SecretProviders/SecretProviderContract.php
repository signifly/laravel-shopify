<?php

namespace Signifly\Shopify\Laravel\Webhooks\SecretProviders;

interface SecretProviderContract
{
    public function getSecret(string $domain): string;
}
