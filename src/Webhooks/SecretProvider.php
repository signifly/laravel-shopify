<?php

namespace Signifly\Shopify\Webhooks;

interface SecretProvider
{
    public function getSecret(string $domain): string;
}
