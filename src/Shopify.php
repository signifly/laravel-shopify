<?php

namespace Signifly\Shopify;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\REST\Actions\CollectAction;
use Signifly\Shopify\REST\Actions\CustomCollectionAction;
use Signifly\Shopify\REST\Actions\DraftOrderAction;
use Signifly\Shopify\REST\Actions\FulfillmentAction;
use Signifly\Shopify\REST\Actions\ImageAction;
use Signifly\Shopify\REST\Actions\OrderAction;
use Signifly\Shopify\REST\Actions\ProductAction;
use Signifly\Shopify\REST\Actions\SmartCollectionAction;
use Signifly\Shopify\REST\Actions\TransactionAction;
use Signifly\Shopify\REST\Actions\VariantAction;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\Support\MakesHttpRequests;

class Shopify
{
    use MakesHttpRequests;

    private string $apiKey;
    private string $password;
    private string $domain;
    private string $apiVersion;

    public function __construct(string $apiKey, string $password, string $domain, string $apiVersion)
    {
        $this->apiKey = $apiKey;
        $this->password = $password;
        $this->domain = $domain;
        $this->apiVersion = $apiVersion;
    }

    public function collects(): CollectAction
    {
        return new CollectAction($this);
    }

    public function customCollection(): CustomCollectionAction
    {
        return new CustomCollectionAction($this);
    }

    public function draftOrders(): DraftOrderAction
    {
        return new DraftOrderAction($this);
    }

    public function fulfillments(): FulfillmentAction
    {
        return new FulfillmentAction($this);
    }

    private function images(): ImageAction
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

    public function productVariants(int $id): VariantAction
    {
        return $this->variants()->with('products', $id);
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

    public function getHttpClient(): PendingRequest
    {
        return Http::baseUrl($this->getBaseUrl())
            ->withBasicAuth($this->apiKey, $this->password);
    }

    public function getBaseUrl(): string
    {
        return "https://{$this->domain}/admin/api/{$this->apiVersion}";
    }
}
