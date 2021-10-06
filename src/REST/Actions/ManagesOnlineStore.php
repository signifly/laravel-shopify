<?php

namespace Signifly\Shopify\REST\Actions;

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

    public function deleteRedirect($redirectId): void
    {
        $this->deleteResource('redirects', $redirectId);
    }
}
