<?php

namespace Signifly\Shopify;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Signifly\Shopify\Exceptions\ErrorHandlerInterface;
use Signifly\Shopify\Exceptions\Handler;
use Signifly\Shopify\Http\Controllers\WebhookController;
use Signifly\Shopify\Webhooks\SecretProvider;
use Signifly\Shopify\Webhooks\Webhook;

class ShopifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishConfig();
        $this->registerMacros();
    }

    public function register()
    {
        $this->app->singleton(Shopify::class, fn () => Factory::fromConfig());

        $this->app->alias(Shopify::class, 'shopify');

        $this->app->bind(ErrorHandlerInterface::class, Handler::class);

        $this->app->singleton(SecretProvider::class, function (Application $app) {
            $secretProvider = config('shopify.webhooks.secret_provider');

            return $app->make($secretProvider);
        });
    }

    protected function publishConfig()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/shopify.php' => config_path('shopify.php'),
            ], 'laravel-shopify');
        }

        $this->mergeConfigFrom(__DIR__.'/../config/shopify.php', 'shopify');
    }

    protected function registerMacros(): void
    {
        Route::macro('shopifyWebhooks', function (string $uri = 'shopify/webhooks') {
            return $this->post($uri, [WebhookController::class, 'handle'])->name('shopify.webhooks');
        });

        Request::macro('shopifyShopDomain', fn () => $this->header(Webhook::HEADER_SHOP_DOMAIN));

        Request::macro('shopifyHmacSignature', fn () => $this->header(Webhook::HEADER_HMAC_SIGNATURE));

        Request::macro('shopifyTopic', fn () => $this->header(Webhook::HEADER_TOPIC));
    }
}
