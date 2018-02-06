<?php

namespace Signifly\Shopify\Webhooks\SecretProviders;

interface SecretProviderContract
{
    public function getSecret(string $domain) : string;
}
