<?php

namespace Signifly\Shopify\REST\Resources;

use Illuminate\Support\Collection;

class ProductResource extends ApiResource
{
    public function images(): Collection
    {
        return $this->transformCollection($this->images, ImageResource::class);
    }

    public function variants(): Collection
    {
        return $this->transformCollection($this->variants, VariantResource::class);
    }
}
