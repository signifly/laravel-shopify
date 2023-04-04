<?php

namespace Signifly\Shopify\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\Factory;
use Signifly\Shopify\REST\Resources\MetafieldResource;
use Signifly\Shopify\Shopify;

class ManagesMetafieldsTest extends TestCase
{
    private Shopify $shopify;

    public function setUp(): void
    {
        parent::setUp();

        $this->shopify = Factory::fromConfig();
    }

    /**
     * @test
     * @dataProvider provideMetafieldCreationData
     */
    public function it_creates_a_metafield(string $method, string $expectedUri, array $params = [])
    {
        Http::fakeSequence()->push($this->fixture('metafields.show'), 200);

        $payload = [
            'namespace' => 'pim',
            'key' => 'some_key',
            'value' => 'some value',
            'value_type' => 'string',
        ];

        array_push($params, $payload);

        $metafield = $this->shopify->$method(...$params);

        Http::assertSent(function (Request $request) use ($payload, $expectedUri) {
            $this->assertEquals($this->shopify->getBaseUrl().$expectedUri, $request->url());
            $this->assertEquals('POST', $request->method());
            $this->assertEquals(['metafield' => $payload], $request->data());

            return true;
        });
        $this->assertInstanceOf(MetafieldResource::class, $metafield);
    }

    public function provideMetafieldCreationData(): array
    {
        $id = 1234;

        return [
            'Shop' => ['createMetafield', '/metafields.json'],
            'Customer' => ['createCustomerMetafield', "/customers/{$id}/metafields.json", [$id]],
            'Product' => ['createProductMetafield', "/products/{$id}/metafields.json", [$id]],
            'Variant' => ['createVariantMetafield', "/variants/{$id}/metafields.json", [$id]],
            'Draft Order' => ['createDraftOrderMetafield', "/draft_orders/{$id}/metafields.json", [$id]],
            'Order' => ['createOrderMetafield', "/orders/{$id}/metafields.json", [$id]],
        ];
    }

    /**
     * @test
     * @dataProvider provideMetafieldCountData
     */
    public function it_gets_metafields_count(string $method, string $expectedUri, array $params = [])
    {
        Http::fakeSequence()->push(['count' => 5], 200);

        $count = $this->shopify->$method(...$params);

        Http::assertSent(function (Request $request) use ($expectedUri) {
            $this->assertEquals($this->shopify->getBaseUrl().$expectedUri, $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertEquals(5, $count);
    }

    public function provideMetafieldCountData()
    {
        $id = 1234;

        return [
            'Shop' => ['getMetafieldsCount', '/metafields/count.json'],
            'Customer' => ['getCustomerMetafieldsCount', "/customers/{$id}/metafields/count.json", [$id]],
            'Product' => ['getProductMetafieldsCount', "/products/{$id}/metafields/count.json", [$id]],
            'Variant' => ['getVariantMetafieldsCount', "/variants/{$id}/metafields/count.json", [$id]],
            'Draft Order' => ['getDraftOrderMetafieldsCount', "/draft_orders/{$id}/metafields/count.json", [$id]],
            'Order' => ['getOrderMetafieldsCount', "/orders/{$id}/metafields/count.json", [$id]],
        ];
    }

    /**
     * @test
     * @dataProvider provideGetMetafieldsData
     */
    public function it_gets_metafields(string $method, string $expectedUri, array $params = [])
    {
        Http::fakeSequence()->push($this->fixture('metafields.all'), 200);

        $metafields = $this->shopify->$method(...$params);

        Http::assertSent(function (Request $request) use ($expectedUri) {
            $this->assertEquals($this->shopify->getBaseUrl().$expectedUri, $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertCount(1, $metafields);
        $this->assertInstanceOf(Collection::class, $metafields);
        $this->assertInstanceOf(MetafieldResource::class, $metafields->first());
    }

    public function provideGetMetafieldsData()
    {
        $id = 1234;

        return [
            'Shop' => ['getMetafields', '/metafields.json'],
            'Customer' => ['getCustomerMetafields', "/customers/{$id}/metafields.json", [$id]],
            'Product' => ['getProductMetafields', "/products/{$id}/metafields.json", [$id]],
            'Variant' => ['getVariantMetafields', "/variants/{$id}/metafields.json", [$id]],
            'Draft Order' => ['getDraftOrderMetafields', "/draft_orders/{$id}/metafields.json", [$id]],
            'Order' => ['getOrderMetafields', "/orders/{$id}/metafields.json", [$id]],
        ];
    }

    /** @test **/
    public function it_updates_a_metafield()
    {
        Http::fakeSequence()->push($this->fixture('metafields.show'), 200);

        $metafield = $this->shopify->updateMetafield(1234, [
            'value' => 'new value',
        ]);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/metafields/1234.json', $request->url());
            $this->assertEquals('PUT', $request->method());

            return true;
        });
        $this->assertInstanceOf(MetafieldResource::class, $metafield);
    }

    /** @test **/
    public function it_deletes_a_metafield()
    {
        Http::fakeSequence()->pushStatus(200);

        $this->shopify->deleteMetafield(1234);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/metafields/1234.json', $request->url());
            $this->assertEquals('DELETE', $request->method());

            return true;
        });
    }
}
