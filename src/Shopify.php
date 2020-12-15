<?php

namespace Signifly\Shopify;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\REST\Actions\CollectAction;
use Signifly\Shopify\REST\Actions\CustomCollectionAction;
use Signifly\Shopify\REST\Actions\ImageAction;
use Signifly\Shopify\REST\Actions\ProductAction;
use Signifly\Shopify\REST\Actions\SmartCollectionAction;
use Signifly\Shopify\REST\Actions\VariantAction;
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

    public function products(): ProductAction
    {
        return new ProductAction($this);
    }

    public function productImages(int $id): ImageAction
    {
        return (new ImageAction($this))->with('products', $id);
    }

    public function productVariants(int $id): VariantAction
    {
        return $this->variants()->with('products', $id);
    }

    public function smartCollections(): SmartCollectionAction
    {
        return new SmartCollectionAction($this);
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
