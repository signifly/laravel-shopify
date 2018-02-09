<?php

namespace Signifly\Shopify\Laravel\Webhooks;

class Webhook
{
    protected $domain;

    protected $payload;

    protected $topic;

    public function __construct(string $domain, string $topic, string $payload)
    {
        $this->domain = $domain;
        $this->payload = $payload;
        $this->$topic = $topic;
    }

    public function domain() : string
    {
        return $this->domain;
    }

    public function payload() : string
    {
        return $this->payload;
    }

    public function topic() : string
    {
        return $this->topic;
    }
}
