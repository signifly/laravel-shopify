<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Cursor;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\REST\Resources\WebhookResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesEvents
{
    public function createEvent(array $data): ApiResource
    {
        return $this->createResource('events', $data);
    }

    public function getEventsCount(array $params = []): int
    {
        return $this->getResourceCount('events', $params);
    }

    public function paginateEvents(array $params = []): Cursor
    {
        return $this->cursor($this->getEvents($params));
    }

    public function getEvents(array $params = []): Collection
    {
        return $this->getResources('events', $params);
    }

    public function createWebhook(array $data): WebhookResource
    {
        return $this->createResource('webhooks', $data);
    }

    public function getWebhooksCount(array $params = []): int
    {
        return $this->getResourceCount('webhooks', $params);
    }

    public function paginateWebhooks(array $params = []): Cursor
    {
        return $this->cursor($this->getWebhooks($params));
    }

    public function getWebhooks(array $params = []): Collection
    {
        return $this->getResources('webhooks', $params);
    }

    public function getWebhook($webhookId): WebhookResource
    {
        return $this->getResource('webhooks', $webhookId);
    }

    public function updateWebhook($webhookId, $data): WebhookResource
    {
        return $this->updateResource('webhooks', $webhookId, $data);
    }

    public function deleteWebhook($webhookId): void
    {
        $this->deleteResource('webhooks', $webhookId);
    }
}
