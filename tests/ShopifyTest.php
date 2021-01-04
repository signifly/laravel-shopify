<?php

namespace Signifly\Shopify\Tests;

use Signifly\Shopify\Shopify;

class ShopifyTest extends TestCase
{
    /** @test **/
    public function it_returns_the_shopify_instance_from_the_container()
    {
        $shopify = $this->app->make('shopify');

        $this->assertInstanceOf(Shopify::class, $shopify);
    }

    /** @test **/
    public function it_returns_the_same_shopify_instance_from_the_container()
    {
        $shopifyA = $this->app->make('shopify');
        $shopifyB = $this->app->make('shopify');

        $this->assertSame($shopifyA, $shopifyB);
    }

    /** @test **/
    public function it_memoizes_the_http_client()
    {
        $shopify = $this->app->make('shopify');

        $clientA = $shopify->getHttpClient();
        $clientB = $shopify->getHttpClient();

        $this->assertSame($clientA, $clientB);
    }

    /** @test **/
    public function it_updates_credentials_and_resets_client()
    {
        $shopify = $this->app->make('shopify');

        $clientA = $shopify->getHttpClient();

        $shopify = $shopify->withCredentials('1234', '1234', '1234', '2021-01');

        $clientB = $shopify->getHttpClient();

        $this->assertNotSame($clientA, $clientB);
    }
}
