<?php

namespace Signifly\Shopify\REST\Resources;

class MetafieldResource extends ApiResource
{
    public function update(array $data): MetafieldResource
    {
        return $this->shopify->updateMetafield($this->id, $data);
    }

    public function delete(): void
    {
        $this->shopify->deleteMetafield($this->id);
    }
}
