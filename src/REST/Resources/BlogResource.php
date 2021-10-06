<?php

namespace Signifly\Shopify\REST\Resources;

class BlogResource extends ApiResource
{
    public function update(array $data): self
    {
        return $this->shopify->updateBlog($this->id, $data);
    }

    public function delete(): void
    {
        $this->shopify->deleteBlog($this->id);
    }
}
