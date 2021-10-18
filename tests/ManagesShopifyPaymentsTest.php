<?php

namespace Signifly\Shopify\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\Factory;
use Signifly\Shopify\REST\Resources\BalanceResource;
use Signifly\Shopify\REST\Resources\DisputeResource;
use Signifly\Shopify\REST\Resources\MetafieldResource;
use Signifly\Shopify\REST\Resources\PayoutResource;
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

    /** @test */
    public function it_gets_a_list_of_disputes()
    {
        Http::fake([
            '*' => Http::response($this->fixture('disputes.all')),
        ]);

        $url = '/shopify_payments/disputes.json';

        $resources = $this->shopify->getDisputes();

        Http::assertSent(function (Request $request) use ($url) {
            $this->assertEquals($this->shopify->getBaseUrl() . $url, $request->url());
            $this->assertEquals('GET', $request->method());
            return true;
        });
        
        $this->assertInstanceOf(Collection::class, $resources);
        
        $this->assertInstanceOf(DisputeResource::class, $resources->first());
        
        $this->assertCount(7, $resources);
    }

    /** @test */
    public function it_finds_a_dispute()
    {
        Http::fake([
            '*' => Http::response($this->fixture('disputes.show')),
        ]);

        $disputeId = '1234';

        $resource = $this->shopify->getDispute($disputeId);

        Http::assertSent(function (Request $request) use ($disputeId) {
            $this->assertEquals($this->shopify->getBaseUrl() . '/shopify_payments/disputes/' . $disputeId . '.json', $request->url());
            $this->assertEquals('GET', $request->method());
            return true;
        });
        
        $this->assertInstanceOf(DisputeResource::class, $resource);
    }

    /** @test */
    public function it_gets_a_list_of_payouts()
    {
        Http::fake([
            '*' => Http::response($this->fixture('payouts.all')),
        ]);

        $resources = $this->shopify->getPayouts();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl() . '/shopify_payments/payouts.json', $request->url());
            $this->assertEquals('GET', $request->method());
            return true;
        });
        
        $this->assertInstanceOf(Collection::class, $resources);
        
        $this->assertInstanceOf(PayoutResource::class, $resources->first());
        
        $this->assertCount(8, $resources);
    }

    /** @test */
    public function it_finds_a_payout()
    {
        Http::fake([
            '*' => Http::response($this->fixture('payouts.show')),
        ]);

        $payoutId = '1234';

        $resource = $this->shopify->getPayout($payoutId);

        Http::assertSent(function (Request $request) use ($payoutId) {
            $this->assertEquals($this->shopify->getBaseUrl() . '/shopify_payments/payouts/' . $payoutId . '.json', $request->url());
            $this->assertEquals('GET', $request->method());
            return true;
        });
        
        $this->assertInstanceOf(PayoutResource::class, $resource);
    }

}
