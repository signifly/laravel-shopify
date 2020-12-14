<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\ResourceKey;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\REST\TransformsResources;
use Signifly\Shopify\Shopify;

abstract class Action
{
    use TransformsResources;

    protected Shopify $shopify;

    protected string $resourceClass;

    protected ResourceKey $resourceKey;

    public function __construct(Shopify $shopify, ?ResourceKey $resourceKey = null)
    {
        $this->shopify = $shopify;
        $this->resourceKey = $resourceKey ?? ResourceKey::fromAction(static::class);
    }

    public function all(array $params = []): Collection
    {
        $response = $this->shopify->get($this->resourceKey->plural().'.json');

        return $this->transformCollectionFromResponse($response);
    }

    public function create(array $data): ApiResource
    {
        $response = $this->shopify->post($this->resourceKey->plural().'.json', [
            $this->resourceKey->singular() => $data,
        ]);

        return $this->transformItemFromResponse($response);
    }

    public function update($id, array $data): ApiResource
    {
        $response = $this->shopify->put($this->resourceKey->plural().'/'.$id.'.json', [
            $this->resourceKey->singular() => $data,
        ]);

        return $this->transformItemFromResponse($response);
    }

    protected function getResourceClass(): string
    {
        $resourceClass = $this->resourceClass;

        throw_unless(class_exists($resourceClass), new \RuntimeException('Resource class does not exist.'));

        if (! $resourceClass instanceof ApiResource) {
            throw new \RuntimeException(
                sprintf('Resource class `%s` must be an instance of `%s`', $resourceClass, ApiResource::class)
            );
        }

        return $resourceClass;
    }

    protected function getResourceKey(): ResourceKey
    {
        return $this->resourceKey;
    }
}
