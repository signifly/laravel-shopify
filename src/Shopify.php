<?php

namespace Signifly\Shopify;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\REST\Actions\ProductAction;
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

    public function products()
    {
        return new ProductAction($this);
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
