<?php

namespace Signifly\Shopify\REST\Resources;

use Illuminate\Support\Collection;

class ProductResource extends ApiResource
{
    public function update(array $data): self
    {
        return $this->shopify->updateProduct($this->id, $data);
    }

    public function delete(): void
    {
        $this->shopify->deleteProduct($this->id);
    }

    public function publish(): self
    {
        return $this->update(['published' => true]);
    }

    public function unpublish(): self
    {
        return $this->update(['published' => false]);
    }

    public function getImages(array $params = []): Collection
    {
        return $this->shopify->getProductImages($this->id, $params);
    }

    public function getMetafields(array $params = []): Collection
    {
        return $this->shopify->getProductMetafields($this->id, $params);
    }

    public function getVariants(array $params = []): Collection
    {
        return $this->shopify->getVariants($this->id, $params);
    }

    public function images(): Collection
    {
        return Collection::make($this->images)
            ->map(fn ($attributes) => new ImageResource($attributes, $this->shopify));
    }

    public function variants(): Collection
    {
        return Collection::make($this->variants)
            ->map(fn ($attributes) => new VariantResource($attributes, $this->shopify));
    }
}
