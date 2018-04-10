<?php

return [
    /*
     * The profile to use.
     */
    'profile' => \Signifly\Shopify\Laravel\Profiles\ConfigProfile::class,

    /*
     * The API key from private app credentials.
     */
    'api_key' => env('SHOPIFY_API_KEY'),

    /*
     * The password from private app credentials.
     */
    'password' => env('SHOPIFY_PASSWORD'),

    /*
     * The shopify domain for your shop.
     */
    'domain' => env('SHOPIFY_DOMAIN'),

    /*
     * The webhook secret provider to use.
     */
    'webhook_secret_provider' => \Signifly\Shopify\Laravel\Webhooks\SecretProviders\ConfigSecretProvider::class,

    /*
     * The shopify webhook secret.
     */
    'webhook_secret' => env('SHOPIFY_WEBHOOK_SECRET'),
];
