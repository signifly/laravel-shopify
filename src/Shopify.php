<?php

namespace Signifly\Shopify;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\REST\Actions\AddressAction;
use Signifly\Shopify\REST\Actions\CollectAction;
use Signifly\Shopify\REST\Actions\CollectionListingAction;
use Signifly\Shopify\REST\Actions\CustomCollectionAction;
use Signifly\Shopify\REST\Actions\CustomerAction;
use Signifly\Shopify\REST\Actions\DraftOrderAction;
use Signifly\Shopify\REST\Actions\EventAction;
use Signifly\Shopify\REST\Actions\FulfillmentAction;
use Signifly\Shopify\REST\Actions\ImageAction;
use Signifly\Shopify\REST\Actions\InventoryItemAction;
use Signifly\Shopify\REST\Actions\InventoryLevelAction;
use Signifly\Shopify\REST\Actions\ManagesCollections;
use Signifly\Shopify\REST\Actions\ManagesProducts;
use Signifly\Shopify\REST\Actions\MetafieldAction;
use Signifly\Shopify\REST\Actions\OrderAction;
use Signifly\Shopify\REST\Actions\ProductAction;
use Signifly\Shopify\REST\Actions\ProductListingAction;
use Signifly\Shopify\REST\Actions\RefundAction;
use Signifly\Shopify\REST\Actions\RiskAction;
use Signifly\Shopify\REST\Actions\SmartCollectionAction;
use Signifly\Shopify\REST\Actions\TransactionAction;
use Signifly\Shopify\REST\Actions\VariantAction;
use Signifly\Shopify\REST\Actions\WebhookAction;
use Signifly\Shopify\REST\Cursor;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\REST\TransformsResources;
use Signifly\Shopify\Support\MakesHttpRequests;

class Shopify
{
    use MakesHttpRequests;
    use TransformsResources;
    use ManagesProducts;
    use ManagesCollections;

    protected string $apiKey;
    protected string $password;
    protected string $domain;
    protected string $apiVersion;

    protected ?PendingRequest $httpClient = null;

    public function __construct(string $apiKey, string $password, string $domain, string $apiVersion)
    {
        $this->apiKey = $apiKey;
        $this->password = $password;
        $this->domain = $domain;
        $this->apiVersion = $apiVersion;
    }

    public function cursor(Collection $results): Cursor
    {
        return new Cursor($this, $results);
    }

    protected function addresses(): AddressAction
    {
        return new AddressAction($this);
    }

    public function collectionListings(): CollectionListingAction
    {
        return new CollectionListingAction($this);
    }

    public function collectionMetafields($collectionId): MetafieldAction
    {
        return $this->metafields()->with('collections', $collectionId);
    }

    public function collects(): CollectAction
    {
        return new CollectAction($this);
    }

    public function customers(): CustomerAction
    {
        return new CustomerAction($this);
    }

    public function customerAddresses($customerId): AddressAction
    {
        return $this->addresses()->with('customers', $customerId);
    }

    public function customCollection(): CustomCollectionAction
    {
        return new CustomCollectionAction($this);
    }

    public function draftOrders(): DraftOrderAction
    {
        return new DraftOrderAction($this);
    }

    public function events(): EventAction
    {
        return new EventAction($this);
    }

    public function fulfillments(): FulfillmentAction
    {
        return new FulfillmentAction($this);
    }

    protected function images(): ImageAction
    {
        return new ImageAction($this);
    }

    public function inventoryItems(): InventoryItemAction
    {
        return new InventoryItemAction($this);
    }

    public function inventoryLevels(): InventoryLevelAction
    {
        return new InventoryLevelAction($this);
    }

    public function metafields(): MetafieldAction
    {
        return new MetafieldAction($this);
    }

    public function orders(): OrderAction
    {
        return new OrderAction($this);
    }

    public function orderFulfillments($orderId): FulfillmentAction
    {
        return $this->fulfillments()->with('orders', $orderId);
    }

    public function orderMetafields($orderId): MetafieldAction
    {
        return $this->metafields()->with('orders', $orderId);
    }

    public function orderRisks($orderId): RiskAction
    {
        return $this->risks()->with('orders', $orderId);
    }

    public function orderTransactions($orderId): TransactionAction
    {
        return $this->transactions()->with('orders', $orderId);
    }

    public function products(): ProductAction
    {
        return new ProductAction($this);
    }

    public function productImages($productId): ImageAction
    {
        return $this->images()->with('products', $productId);
    }

    public function productListings(): ProductListingAction
    {
        return new ProductListingAction($this);
    }

    public function productMetafields($productId): MetafieldAction
    {
        return $this->metafields()->with('products', $productId);
    }

    public function productVariants($productId): VariantAction
    {
        return $this->variants()->with('products', $productId);
    }

    public function refunds(): RefundAction
    {
        return new RefundAction($this);
    }

    protected function risks(): RiskAction
    {
        return new RiskAction($this);
    }

    public function shop(): ApiResource
    {
        $response = $this->get('shop.json');

        return new ApiResource($response->json('shop'), $this);
    }

    public function smartCollections(): SmartCollectionAction
    {
        return new SmartCollectionAction($this);
    }

    protected function transactions(): TransactionAction
    {
        return new TransactionAction($this);
    }

    public function variants(): VariantAction
    {
        return new VariantAction($this);
    }

    public function variantMetafields($variantId): MetafieldAction
    {
        return $this->metafields()->with('variants', $variantId);
    }

    public function webhooks(): WebhookAction
    {
        return new WebhookAction($this);
    }

    public function getHttpClient(): PendingRequest
    {
        return $this->httpClient ??= Http::baseUrl($this->getBaseUrl())
            ->withBasicAuth($this->apiKey, $this->password);
    }

    public function getBaseUrl(): string
    {
        return "https://{$this->domain}/admin/api/{$this->apiVersion}";
    }

    public function tap(callable $callback): self
    {
        $callback($this->getHttpClient());

        return $this;
    }
}
