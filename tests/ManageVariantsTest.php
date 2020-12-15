<?php

namespace Signifly\Shopify\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\Factory;
use Signifly\Shopify\REST\Resources\VariantResource;
use Signifly\Shopify\Shopify;

class ManageVariantsTest extends TestCase
{
    private Shopify $shopify;

    public function setUp(): void
    {
        parent::setUp();

        $this->shopify = Factory::fromConfig();
    }

    /** @test **/
    public function it_lists_all_variants_for_a_product()
    {
        Http::fake([
            '*' => Http::response(['variants' => [
                ['id' => 1234, 'title' => 'Some title'],
                ['id' => 4321, 'title' => 'Some title 2'],
            ]]),
        ]);

        $resources = $this->shopify->getVariants(5432);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/products/5432/variants.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(Collection::class, $resources);
        $this->assertCount(2, $resources);
    }

    /** @test **/
    public function it_creates_a_variant()
    {
        Http::fake([
            '*' => Http::response(['variant' => ['id' => 1234, 'title' => 'Some title']]),
        ]);

        $resource = $this->shopify->createVariant(5432, $payload = [
            'sku' => '12345678',
        ]);

        Http::assertSent(function (Request $request) use ($payload) {
            $this->assertEquals($this->shopify->getBaseUrl().'/products/5432/variants.json', $request->url());
            $this->assertEquals(['variant' => $payload], $request->data());
            $this->assertEquals('POST', $request->method());

            return true;
        });
        $this->assertInstanceOf(VariantResource::class, $resource);
    }

    /** @test **/
    public function it_finds_a_variant()
    {
        Http::fake([
            '*' => Http::response(['variant' => ['sku' => 1234, 'title' => 'Some title']]),
        ]);

        $resource = $this->shopify->getVariant(1234);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/variants/1234.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(VariantResource::class, $resource);
    }

    /** @test **/
    public function it_updates_a_variant()
    {
        Http::fake([
            '*' => Http::response(['variant' => ['id' => 1234, 'sku' => '123456']]),
        ]);

        $resource = $this->shopify->updateVariant(1234, $payload = [
            'sku' => '123456',
        ]);

        Http::assertSent(function (Request $request) use ($payload) {
            $this->assertEquals($this->shopify->getBaseUrl().'/variants/1234.json', $request->url());
            $this->assertEquals(['variant' => $payload], $request->data());
            $this->assertEquals('PUT', $request->method());

            return true;
        });
        $this->assertInstanceOf(VariantResource::class, $resource);
    }

    /** @test **/
    public function it_deletes_a_variant()
    {
        Http::fake([
            '*' => Http::response(),
        ]);

        $this->shopify->deleteVariant(5432, 1234);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/products/5432/variants/1234.json', $request->url());
            $this->assertEquals('DELETE', $request->method());

            return true;
        });
    }

    /** @test **/
    public function it_counts_variants()
    {
        Http::fake([
            '*' => Http::response(['count' => 125]),
        ]);

        $count = $this->shopify->getVariantsCount(5432);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/products/5432/variants/count.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertEquals(125, $count);
    }
}
