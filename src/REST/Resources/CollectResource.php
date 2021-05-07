<?php

namespace Signifly\Shopify\REST\Resources;

class CollectResource extends ApiResource
{
    public function delete(): void
    {
        $this->shopify->deleteCollect($this->id);
    }
}
