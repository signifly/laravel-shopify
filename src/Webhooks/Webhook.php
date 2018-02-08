<?php

namespace Signifly\Shopify\Laravel\Webhooks;

class Webhook
{
    protected $handle;

    protected $payload;

    protected $topic;

    public function __construct(string $handle, string $topic, string $payload)
    {
        $this->handle = $handle;
        $this->payload = $payload;
        $this->$topic = $topic;
    }

    public function handle() : string
    {
        return $this->handle;
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
