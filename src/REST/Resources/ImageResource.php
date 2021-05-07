<?php

namespace Signifly\Shopify\REST\Resources;

class ImageResource extends ApiResource
{
    public function delete(): void
    {
        $this->shopify->deleteProductImage($this->product_id, $this->id);
    }

    public function update(array $data): self
    {
        return $this->shopify->updateProductImage($this->product_id, $this->id, $data);
    }
}
