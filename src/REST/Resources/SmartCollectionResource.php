<?php

namespace Signifly\Shopify\REST\Resources;

use Illuminate\Support\Collection;

class SmartCollectionResource extends ApiResource
{
    public function update(array $data): self
    {
        return $this->shopify->updateSmartCollection($this->id, $data);
    }

    public function delete(): void
    {
        $this->shopify->deleteSmartCollection($this->id);
    }

    public function getProducts(array $params = []): Collection
    {
        return $this->shopify->getCollectionProducts($this->id, $params);
    }
}
