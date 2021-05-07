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

    protected function fixture(string $name): array
    {
        $json = file_get_contents(__DIR__.'/Fixtures/'.$name.'.json');

        return json_decode($json, true);
    }
}
