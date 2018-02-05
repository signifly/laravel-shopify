<?php

namespace Signifly\Shopify\Laravel;

use Signifly\Shopify\Shopify;
use Illuminate\Support\Facades\Route;
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

        Route::macro('shopifyWebhooks', function ($url) {
            return Route::post('laravel-shopify/webhooks', '\Signifly\Shopify\Http\Controllers\WebhookController@handle');
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
