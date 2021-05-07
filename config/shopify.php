<?php

return [

    'credentials' => [

        /*
         * The API key from private app credentials.
         */
        'api_key' => env('SHOPIFY_API_KEY', ''),

        /*
         * The password from private app credentials.
         */
        'password' => env('SHOPIFY_PASSWORD', ''),

        /*
         * The shopify domain for your shop.
         */
        'domain' => env('SHOPIFY_DOMAIN', ''),

        /*
         * The shopify api version.
         */
        'api_version' => env('SHOPIFY_API_VERSION', '2021-01'),

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
