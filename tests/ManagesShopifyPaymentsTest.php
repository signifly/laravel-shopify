<?php

namespace Signifly\Shopify\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\Factory;
use Signifly\Shopify\REST\Resources\BalanceResource;
use Signifly\Shopify\REST\Resources\MetafieldResource;
use Signifly\Shopify\Shopify;

class ManagesShopifyPaymentsTest extends TestCase
{
    private Shopify $shopify;

    public function setUp(): void
    {
        parent::setUp();

        $this->shopify = Factory::fromConfig();
    }

    /** @test */
    public function it_gets_the_balance()
    {
        Http::fake([
            '*' => Http::response($this->fixture('balance.show')),
        ]);

        $url = '/shopify_payments/balance';

        $resource = $this->shopify->getBalance([]);

        Http::assertSent(function (Request $request) use ($url) {
            $this->assertEquals($this->shopify->getBaseUrl() . $url, $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        
        $this->assertInstanceOf(BalanceResource::class, $resource);
    }

}
