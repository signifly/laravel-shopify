<?php

namespace Signifly\Shopify\Laravel\Test;

use Signifly\Shopify\Shopify;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_reaches_the_shopify_api()
    {
        $this->markTestIncomplete();

        $shopify = $this->app->make(Shopify::class);

        $response = $shopify->products()->count();

        $this->assertArrayHasKey('count', $response);
    }
}
