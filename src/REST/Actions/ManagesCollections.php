<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Cursor;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\REST\Resources\CollectResource;
use Signifly\Shopify\REST\Resources\CustomCollectionResource;
use Signifly\Shopify\REST\Resources\ProductResource;
use Signifly\Shopify\REST\Resources\SmartCollectionResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesCollections
{
    public function createCustomCollection(array $data): CustomCollectionResource
    {
        $response = $this->post('custom_collections.json', ['custom_collection' => $data]);

        return new CustomCollectionResource($response['custom_collection'], $this);
    }

    public function getCustomCollectionsCount(array $params = []): int
    {
        $response = $this->get('custom_collections/count.json', $params);

        return $response['count'] ?? 0;
    }

    public function paginateCustomCollections(array $params): Cursor
    {
        return $this->cursor($this->getCustomCollections($params));
    }

    public function getCustomCollections(array $params = []): Collection
    {
        $response = $this->get('custom_collections.json', $params);

        return $this->transformCollection($response['custom_collections'], CustomCollectionResource::class);
    }

    public function getCustomCollection($collectionId): CustomCollectionResource
    {
        $response = $this->get("custom_collections/{$collectionId}.json");

        return new CustomCollectionResource($response['custom_collection'], $this);
    }

    public function updateCustomCollection($collectionId, array $data): CustomCollectionResource
    {
        $response = $this->put("custom_collections/{$collectionId}.json", ['custom_collection' => $data]);

        return new CustomCollectionResource($response['custom_collection'], $this);
    }

    public function deleteCustomCollection($collectionId): void
    {
        $this->delete("custom_collections/{$collectionId}.json");
    }

    public function createSmartCollection(array $data): SmartCollectionResource
    {
        $response = $this->post('smart_collections.json', ['smart_collection' => $data]);

        return new SmartCollectionResource($response['smart_collection'], $this);
    }

    public function getSmartCollectionsCount(array $params = []): int
    {
        $response = $this->get('smart_collections/count.json', $params);

        return $response['count'] ?? 0;
    }

    public function getSmartCollections(array $params = []): Collection
    {
        $response = $this->get('smart_collections.json', $params);

        return $this->transformCollection($response['smart_collections'], SmartCollectionResource::class);
    }

    public function getSmartCollection($collectionId): SmartCollectionResource
    {
        $response = $this->get("smart_collections/{$collectionId}.json");

        return new SmartCollectionResource($response['smart_collection'], $this);
    }

    public function updateSmartCollection($collectionId, array $data): SmartCollectionResource
    {
        $response = $this->put("smart_collections/{$collectionId}.json", ['smart_collection' => $data]);

        return new SmartCollectionResource($response['smart_collection'], $this);
    }

    public function deleteSmartCollection($collectionId): void
    {
        $this->delete("smart_collections/{$collectionId}.json");
    }

    public function reorderSmartCollection($collectionId, array $productIds)
    {
        $response = $this->put("smart_collections/{$collectionId}/order.json", ['products' => $productIds]);

        return new SmartCollectionResource($response['smart_collection'], $this);
    }

    public function createCollect(array $data): CollectResource
    {
        $response = $this->post('collects.json', ['collect' => $data]);

        return new CollectResource($response['collect'], $this);
    }

    public function getCollectsCount(array $params = []): int
    {
        $response = $this->get('collects/count.json', $params);

        return $response['count'] ?? 0;
    }

    public function getCollects(array $params = []): Collection
    {
        $response = $this->get('collects.json', $params);

        return $this->transformCollection($response['collects'], CollectResource::class);
    }

    public function deleteCollect($collectId): void
    {
        $this->delete("collects/{$collectId}.json");
    }

    public function getCollection($collectionId): ApiResource
    {
        $response = $this->get("collections/{$collectionId}.json");

        return new ApiResource($response['collection'], $this);
    }

    public function getCollectionProducts($collectionId, array $params = []): Collection
    {
        $response = $this->get("collections/{$collectionId}/products.json", $params);

        return $this->transformCollection($response['products'], ProductResource::class);
    }
}
