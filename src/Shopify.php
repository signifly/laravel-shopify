<?php

namespace Signifly\Shopify;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\REST\Actions\ManagesCollections;
use Signifly\Shopify\REST\Actions\ManagesEvents;
use Signifly\Shopify\REST\Actions\ManagesInventory;
use Signifly\Shopify\REST\Actions\ManagesMetafields;
use Signifly\Shopify\REST\Actions\ManagesOrders;
use Signifly\Shopify\REST\Actions\ManagesProducts;
use Signifly\Shopify\REST\Cursor;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\Support\TransformsResources;
use Signifly\Shopify\Support\MakesHttpRequests;

class Shopify
{
    use MakesHttpRequests;
    use TransformsResources;
    use ManagesProducts;
    use ManagesCollections;
    use ManagesInventory;
    use ManagesMetafields;
    use ManagesEvents;
    use ManagesOrders;

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

    public function shop(): ApiResource
    {
        $response = $this->get('shop.json');

        return new ApiResource($response->json('shop'), $this);
    }

    public function getHttpClient(): PendingRequest
    {
        return $this->httpClient ??= Http::baseUrl($this->getBaseUrl())
            ->withBasicAuth($this->apiKey, $this->password);
    }

    public function graphQl(): PendingRequest
    {
        return Http::baseUrl($this->getBaseUrl().'/graphql.json')
            ->withHeaders(['X-Shopify-Access-Token' => $this->password]);
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
