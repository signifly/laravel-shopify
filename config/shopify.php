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
     * The shopify handle for you shop.
     */
    'handle' => env('SHOPIFY_HANDLE'),
];
