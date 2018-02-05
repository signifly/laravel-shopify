<?php

return [
    /*
     * The profile to use.
     */
    'profile' => \Signifly\Shopify\Profiles\CredentialsProfile::class,

    /*
     * The API key from private app credentials.
     */
    'api_key' => env('SHOPIFY_API_KEY'),

    /*
     * The password from private app credentials.
     */
    'password' => env('SHOPIFY_PASSWORD'),

    /*
     * The shopify handle for your shop.
     */
    'handle' => env('SHOPIFY_HANDLE'),

    /*
     * The shopify webhook secret provider factory to use.
     */
    'webhook_secret_provider_factory' => \Signifly\Shopify\Webhooks\SecretProviders\ConfigSecretProviderFactory::class,

    /*
     * The shopify webhook secret.
     */
    'webhook_secret' => env('SHOPIFY_WEBHOOK_SECRET'),
];
