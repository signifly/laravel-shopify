<?php

namespace Signifly\Shopify\REST\Resources;

class VariantResource extends ApiResource
{
    public function update(array $data): VariantResource
    {
        return $this->shopify->updateVariant($this->id, $data);
    }

    public function delete(): void
    {
        $this->shopify->deleteVariant($this->product_id, $this->id);
    }
}
