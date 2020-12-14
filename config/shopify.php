<?php

return [
    /*
     * The profile to use.
     */
    'profile' => \Signifly\Shopify\Laravel\Profiles\ConfigProfile::class,

    /*
     * The handlerStack to use.
     */
    'handlerStackProvider' => \Signifly\Shopify\Laravel\Providers\DefaultHandlerStackProvider::class,

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

        /*
         * The shopify api version.
         */
        'api_version' => env('SHOPIFY_API_VERSION'),

    ],

    'rate_limit' => [

        /*
         * The buffer from the max calls limit.
         */
        'buffer' => 3,

        /*
         * The request cycle / leak rate in percentage per second.
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
        'secret_provider' => \Signifly\Shopify\Webhooks\ConfigSecretProvider::class,

        /*
         * The shopify webhook secret.
         */
        'secret' => env('SHOPIFY_WEBHOOK_SECRET'),

    ],
];
