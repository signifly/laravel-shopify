<?php

namespace Signifly\Shopify\REST\Resources;

class ArticleResource extends ApiResource
{
    public function update(array $data): self
    {
        return $this->shopify->updateArticle($this->id, $data);
    }

    public function publish(): self
    {
        return $this->update(['published' => true]);
    }

    public function unpublish(): self
    {
        return $this->update(['published' => false]);
    }

    public function delete(): void
    {
        $this->shopify->deleteArticle($this->id);
    }
}
