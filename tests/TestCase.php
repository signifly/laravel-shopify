<?php

namespace Signifly\Shopify\Laravel\Test;

use Orchestra\Testbench\TestCase as Orchestra;
use Signifly\Shopify\Laravel\ShopifyServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        $this->setApplicationKey();

        parent::setUp();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ShopifyServiceProvider::class,
        ];
    }

    protected function setApplicationKey()
    {
        putenv('APP_KEY=mysecretkey');
    }
}
