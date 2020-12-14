<?php

namespace Signifly\Shopify\Events;

use Illuminate\Queue\SerializesModels;
use Signifly\Shopify\Laravel\Webhooks\Webhook;

class WebhookReceived
{
    use SerializesModels;

    public $webhook;

    /**
     * Create a new event instance.
     *
     * @param Webhook $webhook
     * @return void
     */
    public function __construct(Webhook $webhook)
    {
        $this->webhook = $webhook;
    }
}
