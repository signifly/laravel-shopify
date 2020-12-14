<?php

namespace Signifly\Shopify\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Signifly\Shopify\ShopifyServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        $this->setApplicationKey();

        parent::setUp();
    }

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
