<?php

namespace Signifly\Shopify\Webhooks;

use Illuminate\Http\Request;

class Webhook
{
    const HEADER_HMAC_SIGNATURE = 'X-Shopify-Hmac-Sha256';
    const HEADER_SHOP_DOMAIN = 'X-Shopify-Shop-Domain';
    const HEADER_TOPIC = 'X-Shopify-Topic';

    protected string $domain;
    protected string $topic;
    protected array $payload;

    public function __construct(string $domain, string $topic, array $payload)
    {
        $this->domain = $domain;
        $this->topic = $topic;
        $this->payload = $payload;
    }

    public function domain(): string
    {
        return $this->domain;
    }

    public function eventName(): string
    {
        return 'shopify-webhooks.'.str_replace('/', '-', $this->topic());
    }

    public function payload(): array
    {
        return $this->payload;
    }

    public function topic(): string
    {
        return $this->topic;
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->shopifyShopDomain(),
            $request->shopifyTopic(),
            json_decode($request->getContent(), true)
        );
    }
}
