<?php

namespace Signifly\Shopify\REST\Resources;

class PageResource extends ApiResource
{
    public function update(array $data): self
    {
        return $this->shopify->updatePage($this->id, $data);
    }

    public function delete(): void
    {
        $this->shopify->deletePage($this->id);
    }
}
