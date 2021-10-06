<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Cursor;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesOnlineStore
{
    public function createRedirect(string $path, string $target): ApiResource
    {
        return $this->createResource('redirects', [
            'path' => $path,
            'target' => $target,
        ]);
    }

    public function getRedirectsCount(array $params = []): int
    {
        return $this->getResourceCount('redirects', $params);
    }

    public function paginateRedirects(array $params = []): Cursor
    {
        return $this->cursor($this->getOrders($params));
    }

    public function getRedirects(array $params = []): Collection
    {
        return $this->getResources('redirects', $params);
    }

    public function getRedirect($redirectId): ApiResource
    {
        return $this->getResource('redirects', $redirectId);
    }

    public function updateRedirect($redirectId, $data): ApiResource
    {
        return $this->updateResource('redirects', $redirectId, $data);
    }

    public function deleteRedirect($redirectId): void
    {
        $this->deleteResource('redirects', $redirectId);
    }
}
