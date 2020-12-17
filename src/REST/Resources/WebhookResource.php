<?php

namespace Signifly\Shopify\REST\Resources;

class WebhookResource extends ApiResource
{
    public function update(array $data): WebhookResource
    {
        return $this->shopify->updateWebhook($this->id, $data);
    }

    public function delete(): void
    {
        $this->shopify->deleteWebhook($this->id);
    }
}
