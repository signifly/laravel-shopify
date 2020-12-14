<?php

namespace Signifly\Shopify\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\Factory;
use Signifly\Shopify\REST\Resources\ProductResource;
use Signifly\Shopify\Shopify;

class ManageProductsTest extends TestCase
{
    private Shopify $shopify;

    public function setUp(): void
    {
        parent::setUp();

        $this->shopify = Factory::fromConfig();
    }

    /** @test **/
    public function it_gets_products()
    {
        Http::fake([
            '*' => Http::response(['products' => [
                ['id' => 1234, 'title' => 'Some title'],
                ['id' => 4321, 'title' => 'Some title 2'],
            ]]),
        ]);

        $resources = $this->shopify->products()->all();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/products.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(Collection::class, $resources);
        $this->assertCount(2, $resources);
    }

    /** @test **/
    public function it_creates_a_product()
    {
        Http::fake([
            '*' => Http::response(['product' => ['id' => 1234, 'title' => 'Some title']]),
        ]);

        $resource = $this->shopify->products()->create($payload = [
            'title' => 'Test product',
            'handle' => 'test-product',
        ]);

        Http::assertSent(function (Request $request) use ($payload) {
            $this->assertEquals($this->shopify->getBaseUrl().'/products.json', $request->url());
            $this->assertEquals(['product' => $payload], $request->data());
            $this->assertEquals('POST', $request->method());

            return true;
        });
        $this->assertInstanceOf(ProductResource::class, $resource);
    }

    /** @test **/
    public function it_finds_a_product()
    {
        Http::fake([
            '*' => Http::response(['product' => ['id' => 1234, 'title' => 'Some title']]),
        ]);

        $resource = $this->shopify->products()->find($id = 1234);

        Http::assertSent(function (Request $request) use ($id) {
            $this->assertEquals($this->shopify->getBaseUrl().'/products/'.$id.'.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(ProductResource::class, $resource);
    }

    /** @test **/
    public function it_updates_a_product()
    {
        Http::fake([
            '*' => Http::response(['product' => ['id' => 1234, 'title' => 'Some title']]),
        ]);

        $id = 1234;

        $resource = $this->shopify->products()->update($id, $payload = [
            'title' => 'Test product',
            'handle' => 'test-product',
        ]);

        Http::assertSent(function (Request $request) use ($id, $payload) {
            $this->assertEquals($this->shopify->getBaseUrl().'/products/'.$id.'.json', $request->url());
            $this->assertEquals(['product' => $payload], $request->data());
            $this->assertEquals('PUT', $request->method());

            return true;
        });
        $this->assertInstanceOf(ProductResource::class, $resource);
    }

    /** @test **/
    public function it_deletes_a_product()
    {
        Http::fake([
            '*' => Http::response(),
        ]);

        $id = 1234;

        $this->shopify->products()->destroy($id);

        Http::assertSent(function (Request $request) use ($id) {
            $this->assertEquals($this->shopify->getBaseUrl().'/products/'.$id.'.json', $request->url());
            $this->assertEquals('DELETE', $request->method());

            return true;
        });
    }
}
