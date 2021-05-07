<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Cursor;
use Signifly\Shopify\REST\Resources\ImageResource;
use Signifly\Shopify\REST\Resources\ProductResource;
use Signifly\Shopify\REST\Resources\VariantResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesProducts
{
    public function createProduct(array $data): ProductResource
    {
        return $this->createResource('products', $data);
    }

    public function getProductsCount(array $params = []): int
    {
        return $this->getResourceCount('products', $params);
    }

    public function paginateProducts(array $params = []): Cursor
    {
        return $this->cursor($this->getProducts($params));
    }

    public function getProducts(array $params = []): Collection
    {
        return $this->getResources('products', $params);
    }

    public function getProduct($productId): ProductResource
    {
        return $this->getResource('products', $productId);
    }

    public function updateProduct($productId, $data): ProductResource
    {
        return $this->updateResource('products', $productId, $data);
    }

    public function deleteProduct($productId): void
    {
        $this->deleteResource('products', $productId);
    }

    public function createVariant($productId, array $data): VariantResource
    {
        return $this->createResource('variants', $data, ['products', $productId]);
    }

    public function getVariantsCount($productId, array $params = []): int
    {
        return $this->getResourceCount('variants', $params, ['products', $productId]);
    }

    public function paginateVariants($productId, array $params = []): Cursor
    {
        return $this->cursor($this->getVariants($productId, $params));
    }

    public function getVariants($productId, array $params = []): Collection
    {
        return $this->getResources('variants', $params, ['products', $productId]);
    }

    public function getVariant($variantId): VariantResource
    {
        return $this->getResource('variants', $variantId);
    }

    public function updateVariant($variantId, array $data): VariantResource
    {
        return $this->updateResource('variants', $variantId, $data);
    }

    public function deleteVariant($productId, $variantId): void
    {
        $this->deleteResource('variants', $variantId, ['products', $productId]);
    }

    public function createProductImage($productId, array $data): ImageResource
    {
        return $this->createResource('images', $data, ['products', $productId]);
    }

    public function getProductImagesCount($productId, array $params = []): int
    {
        return $this->getResourceCount('images', $params, ['products', $productId]);
    }

    public function paginateProductImages($productId, array $params = []): Cursor
    {
        return $this->cursor($this->getProductImages($productId, $params));
    }

    public function getProductImages($productId, array $params = []): Collection
    {
        return $this->getResources('images', $params, ['products', $productId]);
    }

    public function getProductImage($productId, $imageId): ImageResource
    {
        return $this->getResource('images', $imageId, ['products', $productId]);
    }

    public function updateProductImage($productId, $imageId, array $data): ImageResource
    {
        return $this->updateResource('images', $imageId, $data, ['products', $productId]);
    }

    public function deleteProductImage($productId, $imageId): void
    {
        $this->deleteResource('images', $imageId, ['products', $productId]);
    }
}
