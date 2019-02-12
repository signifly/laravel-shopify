<?php

namespace Signifly\Shopify\Laravel;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Signifly\Shopify\Profiles\ProfileContract;
use Illuminate\Contracts\Foundation\Application;

class ShopifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig($this->app);

        /*
         * @todo Perhaps allow for options allowing a user to modify aspects of the route...?
         */
        Route::macro('shopifyWebhooks', function () {
            return $this->post('shopify/webhooks', '\Signifly\Shopify\Laravel\Http\Controllers\WebhookController@handle');
        });

        Request::macro('shopifyShopDomain', function () {
            return $this->header('X-Shopify-Shop-Domain');
        });

        Request::macro('shopifyHmacSha256', function () {
            return $this->header('X-Shopify-Hmac-Sha256');
        });

        Request::macro('shopifyShopHandle', function () {
            return str_before($this->shopifyDomain(), '.myshopify.com');
        });

        Request::macro('shopifyTopic', function () {
            return $this->header('X-Shopify-Topic');
        });
    }

    /**
     * Setup the config.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @return void
     */
    protected function setupConfig(Application $app)
    {
        $this->publishes([
            __DIR__.'/../config/shopify.php' => config_path('shopify.php'),
        ], 'laravel-shopify');

        $this->mergeConfigFrom(__DIR__.'/../config/shopify.php', 'shopify');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Shopify::class, function () {
            return new Shopify(
                $this->getProfile(config('shopify'))
            );
        });

        $this->app->alias(Shopify::class, 'shopify');
    }

    /**
     * Get the profile for the Shopify Client instance.
     *
     * @param  array $config
     * @return \Signifly\Shopify\Profiles\ProfileContract
     */
    protected function getProfile(array $config) : ProfileContract
    {
        $profileClass = $config['profile'];

        return new $profileClass();
    }
}
