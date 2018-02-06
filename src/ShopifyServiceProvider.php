<?php

namespace Signifly\Shopify\Laravel;

use Signifly\Shopify\Shopify;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Signifly\Shopify\Profiles\ProfileContract;
use Illuminate\Contracts\Foundation\Application;

class ShopifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->setupConfig($this->app);

        /**
         * @todo Perhaps allow for options allowing a user to modify aspects of the route...?
         */
        Route::macro('shopifyWebhooks', function () {
            return Route::post('laravel-shopify/webhooks', '\Signifly\Shopify\Http\Controllers\WebhookController@handle');
        });

        Request::macro('shopifyShopDomain', function () {
            return $request->header('X-Shopify-Shop-Domain');
        });

        Request::macro('shopifyHmacSha256', function () {
            return $request->header('X-Shopify-Hmac-Sha256');
        });

        Request::macro('shopifyShopHandle', function () {
            return str_before($request->shopifyDomain(), '.myshopify.com');
        });

        Request::macro('shopifyTopic', function () {
            return $request->header('X-Shopify-Topic');
        });
    }

    /**
     * Setup the config.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    protected function setupConfig(Application $app)
    {
        $source = realpath(__DIR__.'/../config/shopify.php');

        $this->publishes([
            $source => config_path('shopify.php'),
        ]);

        $this->mergeConfigFrom($source, 'shopify');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/shopify.php', 'shopify');

        $config = config('shopify');

        $this->app->singleton(Shopify::class, function () use ($config) {
            return new Shopify(
                $this->getProfile($config)
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
    protected function getProfile($config) : ProfileContract
    {
        $profileClass = $config['profile'];
        return new $profileClass($config['api_key'], $config['password'], $config['handle']);
    }
}
