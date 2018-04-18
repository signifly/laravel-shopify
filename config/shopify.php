<?php

return [
    /*
     * The profile to use.
     */
    'profile' => \Signifly\Shopify\Laravel\Profiles\ConfigProfile::class,

    /*
     * The handlerStack to use.
     */
    'handlerStackProvider' => \Signifly\Shopify\Laravel\HandlerStacks\DefaultHandlerStackProvider::class,

    'credentials' => [

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

    ],

    'rate_limit' => [

        /*
         * The buffer from the max calls limit.
         */
        'buffer' => 3,

        /*
         * The request cycle.
         */
        'cycle' => 0.5,

        /*
         * The processes that can run in parallel.
         */
        'processes' => 1,

    ],

    'webhooks' => [

        /*
         * The webhook secret provider to use.
         */
        'secret_provider' => \Signifly\Shopify\Laravel\Webhooks\SecretProviders\ConfigSecretProvider::class,

        /*
         * The shopify webhook secret.
         */
        'secret' => env('SHOPIFY_WEBHOOK_SECRET'),

    ],
];
