<?php

namespace Signifly\Shopify;

use Illuminate\Http\Client\PendingRequest;
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
use Signifly\Shopify\REST\Actions\OrderAction;
use Signifly\Shopify\REST\Actions\ProductAction;
use Signifly\Shopify\REST\Actions\ProductListingAction;
use Signifly\Shopify\REST\Actions\RefundAction;
use Signifly\Shopify\REST\Actions\RiskAction;
use Signifly\Shopify\REST\Actions\SmartCollectionAction;
use Signifly\Shopify\REST\Actions\TransactionAction;
use Signifly\Shopify\REST\Actions\VariantAction;
use Signifly\Shopify\REST\Actions\WebhookAction;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\Support\MakesHttpRequests;

class Shopify
{
    use MakesHttpRequests;

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

    protected function addresses(): AddressAction
    {
        return new AddressAction($this);
    }

    public function collectionListings(): CollectionListingAction
    {
        return new CollectionListingAction($this);
    }

    public function collects(): CollectAction
    {
        return new CollectAction($this);
    }

    public function customers(): CustomerAction
    {
        return new CustomerAction($this);
    }

    public function customerAddresses($id): AddressAction
    {
        return $this->addresses()->with('customers', $id);
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

    public function orders(): OrderAction
    {
        return new OrderAction($this);
    }

    public function orderFulfillments($id): FulfillmentAction
    {
        return $this->fulfillments()->with('orders', $id);
    }

    public function orderRisks($id): RiskAction
    {
        return $this->risks()->with('orders', $id);
    }

    public function orderTransactions($id): TransactionAction
    {
        return $this->transactions()->with('orders', $id);
    }

    public function products(): ProductAction
    {
        return new ProductAction($this);
    }

    public function productImages(int $id): ImageAction
    {
        return $this->images()->with('products', $id);
    }

    public function productListings(): ProductListingAction
    {
        return new ProductListingAction($this);
    }

    public function productVariants(int $id): VariantAction
    {
        return $this->variants()->with('products', $id);
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

    private function transactions(): TransactionAction
    {
        return new TransactionAction($this);
    }

    public function variants(): VariantAction
    {
        return new VariantAction($this);
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
