<?php

namespace Signifly\Shopify\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\Factory;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\Shopify;

class ManagesOnlineStoreTest extends TestCase
{
    private Shopify $shopify;

    public function setUp(): void
    {
        parent::setUp();

        $this->shopify = Factory::fromConfig();
    }

    /** @test **/
    public function it_creates_a_redirect()
    {
        Http::fake([
            '*' => Http::response($this->fixture('redirects.create')),
        ]);

        $resource = $this->shopify->createRedirect('/ipod', '/pages/itunes');

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/redirects.json', $request->url());
            $this->assertEquals(['redirect' => ['path' => '/ipod', 'target' => '/pages/itunes']], $request->data());
            $this->assertEquals('POST', $request->method());

            return true;
        });
        $this->assertInstanceOf(ApiResource::class, $resource);
    }

    /** @test * */
    public function it_deletes_a_redirect()
    {
        Http::fake([
            '*' => Http::response(),
        ]);

        $id = 1234;

        $this->shopify->deleteRedirect($id);

        Http::assertSent(function (Request $request) use ($id) {
            $this->assertEquals($this->shopify->getBaseUrl().'/redirects/'.$id.'.json', $request->url());
            $this->assertEquals('DELETE', $request->method());

            return true;
        });
    }
}
