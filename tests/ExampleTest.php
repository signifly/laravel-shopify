<?php

namespace Signifly\Shopify\Laravel\Test;

use Signifly\Shopify\Shopify;

class ExampleTest extends TestCase
{
    /** @test */
    function it_reaches_the_shopify_api()
    {
        $shopify = $this->app->make(Shopify::class);

        $response = $shopify->products()->count();

        $this->assertArrayHasKey('count', $response);
    }
}
