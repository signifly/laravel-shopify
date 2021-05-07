<?php

namespace Signifly\Shopify\REST\Resources;

use Illuminate\Support\Collection;

class CustomCollectionResource extends ApiResource
{
    public function update(array $data): self
    {
        return $this->shopify->updateCustomCollection($this->id, $data);
    }

    public function delete(): void
    {
        $this->shopify->deleteCustomCollection($this->id);
    }

    public function getProducts(array $params = []): Collection
    {
        return $this->shopify->getCollectionProducts($this->id, $params);
    }
}
