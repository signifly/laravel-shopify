<?php

namespace Signifly\Shopify\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\Factory;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\Shopify;

class ManageWebhooksTest extends TestCase
{
    private Shopify $shopify;

    public function setUp(): void
    {
        parent::setUp();

        $this->shopify = Factory::fromConfig();
    }

    /** @test **/
    public function it_creates_a_webhook()
    {
        Http::fake([
            '*' => Http::response($this->fixture('webhooks.create')),
        ]);

        $resource = $this->shopify->webhooks()->create($payload = [
            'topic' => 'orders/create',
            'address' => 'https://whatever.hostname.com/',
            'format' => 'json',
        ]);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/webhooks.json', $request->url());
            $this->assertEquals('POST', $request->method());

            return true;
        });
        $this->assertInstanceOf(ApiResource::class, $resource);
    }
}
