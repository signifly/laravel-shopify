<?php

namespace Signifly\Shopify\REST;

use Illuminate\Support\Collection;
use Iterator;
use RuntimeException;
use Signifly\Shopify\Shopify;

class Cursor implements Iterator
{
    use TransformsResources;

    const LINK_REGEX = '/<(.*page_info=([a-z0-9\-]+).*)>; rel="?{type}"?/i';

    protected Shopify $shopify;

    protected ResourceKey $resourceKey;

    protected int $position = 0;

    protected array $links = [];

    protected array $results = [];

    public function __construct(Shopify $shopify, ResourceKey $resourceKey, array $response)
    {
        $this->shopify = $shopify;
        $this->resourceKey = $resourceKey;
        $this->results[$this->position] = $response;

        $this->extractLinks();
    }

    public function current(): Collection
    {
        return $this->transformCollectionFromResponse(
            $this->results[$this->position]
        );
    }

    public function hasNext(): bool
    {
        return ! empty($this->links['next']);
    }

    public function hasPrev(): bool
    {
        return $this->position > 0;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position++;

        if (! $this->valid() && $this->hasNext()) {
            $this->results[$this->position] = $this->shopify->get($this->links['next']);
            $this->extractLinks();
        }
    }

    public function prev(): void
    {
        if (! $this->hasPrev()) {
            throw new RuntimeException('No previous results available.');
        }

        $this->position--;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->results[$this->position]);
    }

    protected function extractLinks(): void
    {
        $response = $this->shopify->getLastResponse();

        if (! $response->header('Link')) {
            return;
        }

        $links = [
            'next' => null,
            'previous' => null,
        ];

        foreach (array_keys($links) as $type) {
            $matched = preg_match(
                str_replace('{type}', $type, static::LINK_REGEX),
                $response->header('Link')[0],
                $matches
            );

            if ($matched) {
                $links[$type] = $matches[1];
            }
        }

        $this->links = $links;
    }

    protected function getResourceKey(): ResourceKey
    {
        return $this->resourceKey;
    }
}
