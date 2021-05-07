<?php

namespace Signifly\Shopify\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\Factory;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\Shopify;

class ManagesInventoryTest extends TestCase
{
    private Shopify $shopify;

    public function setUp(): void
    {
        parent::setUp();

        $this->shopify = Factory::fromConfig();
    }

    /** @test **/
    public function it_gets_locations_count()
    {
        Http::fakeSequence()->push($this->fixture('locations.count'));

        $count = $this->shopify->getLocationsCount();

        $this->assertEquals(5, $count);
        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/locations/count.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
    }

    /** @test **/
    public function it_gets_locations()
    {
        Http::fakeSequence()->push($this->fixture('locations.all'));

        $locations = $this->shopify->getLocations(['limit' => 200]);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/locations.json?limit=200', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(Collection::class, $locations);
        $this->assertInstanceOf(ApiResource::class, $locations->first());
        $this->assertCount(5, $locations);
    }

    /** @test **/
    public function it_gets_a_location()
    {
        Http::fakeSequence()->push($this->fixture('locations.show'));

        $location = $this->shopify->getLocation(1234);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/locations/1234.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(ApiResource::class, $location);
    }

    /** @test **/
    public function it_gets_inventory_levels_for_a_location()
    {
        Http::fakeSequence()->push($this->fixture('locations.inventoryLevels'));

        $inventoryLevels = $this->shopify->getLocationInventoryLevels(1234);

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/locations/1234/inventory_levels.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(Collection::class, $inventoryLevels);
        $this->assertInstanceOf(ApiResource::class, $inventoryLevels->first());
        $this->assertCount(4, $inventoryLevels);
    }
}
