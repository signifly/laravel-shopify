<?php

namespace Signifly\Shopify\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\Factory;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\Shopify;

class ManagesDiscountsTest extends TestCase
{
    private Shopify $shopify;

    public function setUp(): void
    {
        parent::setUp();

        $this->shopify = Factory::fromConfig();
    }

    /** @test **/
    public function it_gets_discount_codes()
    {
        Http::fake([
            '*' => Http::response($this->fixture('discountCodes.all')),
        ]);

        $resources = $this->shopify->getDiscountCodes(1234);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/price_rules/1234/discount_codes.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(Collection::class, $resources);
        $this->assertInstanceOf(ApiResource::class, $resources->first());
        $this->assertCount(1, $resources);
    }

    /** @test **/
    public function it_creates_a_discount_code()
    {
        Http::fake([
            '*' => Http::response($this->fixture('discountCodes.show')),
        ]);

        $resource = $this->shopify->createDiscountCode(1234, 'DISCOUNT20');

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/price_rules/1234/discount_codes.json', $request->url());
            $this->assertEquals(['discount_code' => ['code' => 'DISCOUNT20']], $request->data());
            $this->assertEquals('POST', $request->method());

            return true;
        });
        $this->assertInstanceOf(ApiResource::class, $resource);
    }

    /** @test **/
    public function it_finds_a_discount_code()
    {
        Http::fake([
            '*' => Http::response($this->fixture('discountCodes.show')),
        ]);

        $resource = $this->shopify->getDiscountCode(1234, 5678);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/price_rules/1234/discount_codes/5678.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(ApiResource::class, $resource);
    }

    /** @test **/
    public function it_updates_a_discount_code()
    {
        Http::fake([
            '*' => Http::response($this->fixture('discountCodes.show')),
        ]);

        $resource = $this->shopify->updateDiscountCode(1234, 5678, '20OFF');

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/price_rules/1234/discount_codes/5678.json', $request->url());
            $this->assertEquals(['discount_code' => ['code' => '20OFF']], $request->data());
            $this->assertEquals('PUT', $request->method());

            return true;
        });
        $this->assertInstanceOf(ApiResource::class, $resource);
    }

    /** @test **/
    public function it_deletes_a_discount_code()
    {
        Http::fake([
            '*' => Http::response(),
        ]);

        $this->shopify->deleteDiscountCode(1234, 5678);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/price_rules/1234/discount_codes/5678.json', $request->url());
            $this->assertEquals('DELETE', $request->method());

            return true;
        });
    }

    /** @test **/
    public function it_counts_discount_codes()
    {
        Http::fake([
            '*' => Http::response(['count' => 125]),
        ]);

        $count = $this->shopify->getDiscountCodesCount();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/discount_codes/count.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertEquals(125, $count);
    }

    /** @test **/
    public function it_gets_price_rules()
    {
        Http::fake([
            '*' => Http::response($this->fixture('priceRules.all')),
        ]);

        $resources = $this->shopify->getPriceRules();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/price_rules.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(Collection::class, $resources);
        $this->assertInstanceOf(ApiResource::class, $resources->first());
        $this->assertCount(2, $resources);
    }

    /** @test **/
    public function it_creates_a_price_rule()
    {
        Http::fake([
            '*' => Http::response($this->fixture('priceRules.show')),
        ]);

        $resource = $this->shopify->createPriceRule($payload = [
            'title' => 'SUMMERSALE10OFF',
            'target_type' => 'line_item',
            'target_selection' => 'all',
            'allocation_method' => 'across',
            'value_type' => 'fixed_amount',
            'value' => '-10.0',
            'customer_selection' => 'all',
            'starts_at' => '2017-01-19T17:59:10Z',
        ]);

        Http::assertSent(function (Request $request) use ($payload) {
            $this->assertEquals($this->shopify->getBaseUrl().'/price_rules.json', $request->url());
            $this->assertEquals(['price_rule' => $payload], $request->data());
            $this->assertEquals('POST', $request->method());

            return true;
        });
        $this->assertInstanceOf(ApiResource::class, $resource);
    }

    /** @test **/
    public function it_finds_a_price_rule()
    {
        Http::fake([
            '*' => Http::response($this->fixture('priceRules.show')),
        ]);

        $resource = $this->shopify->getPriceRule(1234);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/price_rules/1234.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(ApiResource::class, $resource);
    }

    /** @test **/
    public function it_updates_a_price_rule()
    {
        Http::fake([
            '*' => Http::response($this->fixture('priceRules.show')),
        ]);

        $resource = $this->shopify->updatePriceRule(1234, [
            'title' => 'SUMMERSALE10POFF',
        ]);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/price_rules/1234.json', $request->url());
            $this->assertEquals(['price_rule' => ['title' => 'SUMMERSALE10POFF']], $request->data());
            $this->assertEquals('PUT', $request->method());

            return true;
        });
        $this->assertInstanceOf(ApiResource::class, $resource);
    }

    /** @test **/
    public function it_deletes_a_price_rule()
    {
        Http::fake([
            '*' => Http::response(),
        ]);

        $this->shopify->deletePriceRule(1234);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/price_rules/1234.json', $request->url());
            $this->assertEquals('DELETE', $request->method());

            return true;
        });
    }

    /** @test **/
    public function it_counts_price_rules()
    {
        Http::fake([
            '*' => Http::response(['count' => 125]),
        ]);

        $count = $this->shopify->getPriceRulesCount();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/price_rules/count.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertEquals(125, $count);
    }
}
