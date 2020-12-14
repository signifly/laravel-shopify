<?php

namespace Signifly\Shopify\REST;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Resources\ApiResource;

trait TransformsResources
{
    abstract protected function getResourceKey(): ResourceKey;

    protected function transformCollection(array $items, string $class): Collection
    {
        return collect($items)->map(function ($attributes) use ($class) {
            return $this->transformItem($attributes, $class);
        });
    }

    protected function transformCollectionFromResponse(Response $response): Collection
    {
        $collection = $response[$this->getResourceKey()->plural()];

        return $this->transformCollection(
            $collection,
            $this->resourceClass
        );
    }

    protected function transformItem(array $attributes, string $class): ApiResource
    {
        return new $class($attributes, $this->shopify);
    }

    protected function transformItemFromResponse(Response $response): ApiResource
    {
        return $this->transformItem(
            $response[$this->getResourceKey()->singular()],
            $this->resourceClass
        );
    }
}
