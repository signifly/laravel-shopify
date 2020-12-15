<?php

namespace Signifly\Shopify\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\Factory;
use Signifly\Shopify\REST\Cursor;
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
            '*' => Http::response($this->fixture('products.all')),
        ]);

        $resources = $this->shopify->getProducts();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/products.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(Collection::class, $resources);
        $this->assertInstanceOf(ProductResource::class, $resources->first());
        $this->assertCount(2, $resources);
    }

    /** @test **/
    public function it_creates_a_product()
    {
        Http::fake([
            '*' => Http::response($this->fixture('products.show')),
        ]);

        $resource = $this->shopify->createProduct($payload = [
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
            '*' => Http::response($this->fixture('products.show')),
        ]);

        $resource = $this->shopify->getProduct($id = 1234);

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
            '*' => Http::response($this->fixture('products.show')),
        ]);

        $id = 1234;

        $resource = $this->shopify->updateProduct($id, $payload = [
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

        $this->shopify->deleteProduct($id);

        Http::assertSent(function (Request $request) use ($id) {
            $this->assertEquals($this->shopify->getBaseUrl().'/products/'.$id.'.json', $request->url());
            $this->assertEquals('DELETE', $request->method());

            return true;
        });
    }

    /** @test **/
    public function it_counts_products()
    {
        Http::fake([
            '*' => Http::response(['count' => 125]),
        ]);

        $count = $this->shopify->getProductsCount();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/products/count.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertEquals(125, $count);
    }

    /** @test **/
    public function it_paginates_products()
    {
        $count = $this->shopify->getProductsCount();
        $pages = $this->shopify->paginateProducts(['limit' => 250]);

        $results = collect();

        foreach ($pages as $page) {
            $results = $results->merge($page);
        }

        $this->assertInstanceOf(Cursor::class, $pages);
        $this->assertEquals($count, $results->count());
    }
}
