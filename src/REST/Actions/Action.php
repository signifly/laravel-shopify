<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Path;
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

    protected ?string $parent = null;

    protected ?string $parentId = null;

    public function __construct(Shopify $shopify, ?ResourceKey $resourceKey = null)
    {
        $this->shopify = $shopify;
        $this->resourceKey = $resourceKey ?? ResourceKey::fromAction(static::class);
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

    protected function hasParent(): bool
    {
        return $this->parent && $this->parentId;
    }

    protected function parentPath(): string
    {
        return $this->hasParent() ? "{$this->parent}/{$this->parentId}" : '';
    }

    protected function path(?string $id = null): Path
    {
        return Path::make($this->resourceKey)
            ->prepends($this->parentPath())
            ->withId($id);
    }

    public function with(string $parent, string $parentId): self
    {
        $this->parent = $parent;
        $this->parentId = $parentId;

        return $this;
    }
}
