<?php

namespace Signifly\Shopify\Tests;

use Signifly\Shopify\REST\Actions\FulfillmentAction;
use Signifly\Shopify\REST\Actions\ImageAction;
use Signifly\Shopify\REST\Actions\InventoryItemAction;
use Signifly\Shopify\REST\Actions\InventoryLevelAction;
use Signifly\Shopify\REST\Actions\MetafieldAction;
use Signifly\Shopify\REST\Actions\OrderAction;
use Signifly\Shopify\REST\Actions\ProductAction;
use Signifly\Shopify\Shopify;

class ShopifyTest extends TestCase
{
    /** @test **/
    public function it_returns_the_shopify_instance_from_the_container()
    {
        $shopify = $this->app->make('shopify');

        $this->assertInstanceOf(Shopify::class, $shopify);
    }

    /** @test **/
    public function it_returns_the_same_shopify_instance_from_the_container()
    {
        $shopifyA = $this->app->make('shopify');
        $shopifyB = $this->app->make('shopify');

        $this->assertSame($shopifyA, $shopifyB);
    }

    /** @test **/
    public function it_memoizes_the_http_client()
    {
        $shopify = $this->app->make('shopify');

        $clientA = $shopify->getHttpClient();
        $clientB = $shopify->getHttpClient();

        $this->assertSame($clientA, $clientB);
    }

    /**
     * @test
     * @dataProvider getMappedActions
     */
    public function it_performs_actions($method, $actionClass, array $params = [])
    {
        $shopify = $this->app->make('shopify');

        $action = $shopify->$method(...$params);
        $this->assertInstanceOf($actionClass, $action);
    }

    public function getMappedActions()
    {
        $id = 1234;

        return [
            'Inventory Item' => ['inventoryItems', InventoryItemAction::class],
            'Inventory Level' => ['inventoryLevels', InventoryLevelAction::class],
            'Fulfillment' => ['fulfillments', FulfillmentAction::class],
            'Metafield' => ['metafields', MetafieldAction::class],
            'Order' => ['orders', OrderAction::class],
            'Order Metafield' => ['orderMetafields', MetafieldAction::class, [$id]],
            'Product' => ['products', ProductAction::class],
            'Product Image' => ['productImages', ImageAction::class, [$id]],
            'Product Metafield' => ['productMetafields', MetafieldAction::class, [$id]],
        ];
    }
}
