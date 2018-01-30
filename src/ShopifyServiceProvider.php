<?php

namespace Signifly\Shopify\Laravel;

use Signifly\Shopify\Shopify;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class ShopifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->setupConfig($this->app);
    }

    /**
     * Setup the config.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    protected function setupConfig(Application $app)
    {
        $source = realpath(__DIR__.'/../config/shopify.php');
        $this->publishes([$source => config_path('shopify.php')]);
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
                $config['api_key'],
                $config['password'],
                $config['handle']
            );
        });

        $this->app->alias(Shopify::class, 'shopify');
    }
}
