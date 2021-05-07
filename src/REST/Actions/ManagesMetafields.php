<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Resources\MetafieldResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesMetafields
{
    public function createMetafield(array $data): MetafieldResource
    {
        return $this->createResource('metafields', $data);
    }

    public function getMetafieldsCount(array $params = []): int
    {
        return $this->getResourceCount('metafields', $params);
    }

    public function getMetafields(array $params = []): Collection
    {
        return $this->getResources('metafields', $params);
    }

    public function getMetafield($metafieldId): MetafieldResource
    {
        return $this->getResource('metafields', $metafieldId);
    }

    public function updateMetafield($metafieldId, array $data): MetafieldResource
    {
        return $this->updateResource('metafields', $metafieldId, $data);
    }

    public function deleteMetafield($metafieldId): void
    {
        $this->deleteResource('metafields', $metafieldId);
    }

    public function createProductMetafield($productId, array $data): MetafieldResource
    {
        return $this->createResource('metafields', $data, ['products', $productId]);
    }

    public function getProductMetafieldsCount($productId, array $params = []): int
    {
        return $this->getResourceCount('metafields', $params, ['products', $productId]);
    }

    public function getProductMetafields($productId, array $params = []): Collection
    {
        return $this->getResources('metafields', $params, ['products', $productId]);
    }

    public function createVariantMetafield($variantId, array $data): MetafieldResource
    {
        return $this->createResource('metafields', $data, ['variants', $variantId]);
    }

    public function getVariantMetafieldsCount($variantId, array $params = []): int
    {
        return $this->getResourceCount('metafields', $params, ['variants', $variantId]);
    }

    public function getVariantMetafields($variantId, array $params = []): Collection
    {
        return $this->getResources('metafields', $params, ['variants', $variantId]);
    }

    public function createProductVariantMetafield($productId, $variantId, array $data): MetafieldResource
    {
        return $this->createResource('metafields', $data, ['products', $productId, 'variants', $variantId]);
    }

    public function getProductVariantMetafieldsCount($productId, $variantId, array $params = []): int
    {
        return $this->getResourceCount('metafields', $params, ['products', $productId, 'variants', $variantId]);
    }

    public function getProductVariantMetafields($productId, $variantId, array $params = []): Collection
    {
        return $this->getResources('metafields', $params, ['products', $productId, 'variants', $variantId]);
    }

    public function createDraftOrderMetafield($orderId, array $data): MetafieldResource
    {
        return $this->createResource('metafields', $data, ['draft_orders', $orderId]);
    }

    public function getDraftOrderMetafieldsCount($orderId, array $params = []): int
    {
        return $this->getResourceCount('metafields', $params, ['draft_orders', $orderId]);
    }

    public function getDraftOrderMetafields($orderId, array $params = []): Collection
    {
        return $this->getResources('metafields', $params, ['draft_orders', $orderId]);
    }

    public function createOrderMetafield($orderId, array $data): MetafieldResource
    {
        return $this->createResource('metafields', $data, ['orders', $orderId]);
    }

    public function getOrderMetafieldsCount($orderId, array $params = []): int
    {
        return $this->getResourceCount('metafields', $params, ['orders', $orderId]);
    }

    public function getOrderMetafields($orderId, array $params = []): Collection
    {
        return $this->getResources('metafields', $params, ['orders', $orderId]);
    }

    public function createCollectionMetafield($collectionId, array $data): MetafieldResource
    {
        return $this->createResource('metafields', $data, ['collections', $collectionId]);
    }

    public function getCollectionMetafieldsCount($collectionId, array $params = []): int
    {
        return $this->getResourceCount('metafields', $params, ['collections', $collectionId]);
    }

    public function getCollectionMetafields($collectionId, array $params = []): Collection
    {
        return $this->getResources('metafields', $params, ['collections', $collectionId]);
    }
}
