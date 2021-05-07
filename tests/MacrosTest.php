<?php

namespace Signifly\Shopify\Tests;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class MacrosTest extends TestCase
{
    /** @test **/
    public function it_registers_shopify_webhooks_macro_on_route()
    {
        $this->assertTrue(Route::hasMacro('shopifyWebhooks'));
    }

    /** @test **/
    public function it_register_shopify_macros_on_request()
    {
        $this->assertTrue(Request::hasMacro('shopifyShopDomain'));
        $this->assertTrue(Request::hasMacro('shopifyHmacSignature'));
        $this->assertTrue(Request::hasMacro('shopifyTopic'));
    }

    /** @test **/
    public function it_registers_endpoint_when_using_shopify_webhooks_macro()
    {
        Route::shopifyWebhooks();

        Route::getRoutes()->refreshNameLookups();

        $this->assertTrue(Route::has('shopify.webhooks'));
    }
}
