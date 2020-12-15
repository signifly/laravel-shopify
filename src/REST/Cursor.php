<?php

namespace Signifly\Shopify\REST;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Iterator;
use RuntimeException;
use Signifly\Shopify\Shopify;

class Cursor implements Iterator
{
    const LINK_REGEX = '/<(.*page_info=([a-z0-9\-]+).*)>; rel="?{type}"?/i';

    protected Shopify $shopify;
    protected int $position = 0;
    protected array $links = [];
    protected array $results = [];
    protected string $resourceClass;

    public function __construct(Shopify $shopify, Collection $results)
    {
        $this->shopify = $shopify;
        $this->results[$this->position] = $results;

        $this->detectResourceClass();
        $this->extractLinks();
    }

    public function current(): Collection
    {
        return $this->results[$this->position];
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
            $this->results[$this->position] = $this->fetchNextResults();
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
            $this->links = [];

            return;
        }

        $links = [
            'next' => null,
            'previous' => null,
        ];

        foreach (array_keys($links) as $type) {
            $matched = preg_match(
                str_replace('{type}', $type, static::LINK_REGEX),
                $response->header('Link'),
                $matches
            );

            if ($matched) {
                $links[$type] = $matches[1];
            }
        }

        $this->links = $links;
    }

    protected function fetchNextResults(): Collection
    {
        $response = $this->shopify->get(
            Str::after($this->links['next'], $this->shopify->getBaseUrl())
        );

        return Collection::make(Arr::first($response->json()))
            ->map(fn ($attr) => new $this->resourceClass($attr, $this->shopify));
    }

    private function detectResourceClass()
    {
        if ($resource = optional($this->results[0])->first()) {
            $this->resourceClass = get_class($resource);
        }
    }
}
