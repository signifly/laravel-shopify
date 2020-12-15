<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Cursor;
use Signifly\Shopify\REST\Resources\ProductImageResource;
use Signifly\Shopify\REST\Resources\ProductResource;
use Signifly\Shopify\REST\Resources\VariantResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesProducts
{
    public function createProduct(array $data): ProductResource
    {
        $response = $this->post('products.json', ['product' => $data]);

        return new ProductResource($response['product'], $this);
    }

    public function getProductsCount(array $params = []): int
    {
        $response = $this->get('products/count.json', $params);

        return $response['count'] ?? 0;
    }

    public function paginateProducts(array $params = []): Cursor
    {
        return $this->cursor($this->getProducts($params));
    }

    public function getProducts(array $params = []): Collection
    {
        $response = $this->get('products.json', $params);

        return $this->transformCollection($response['products'], ProductResource::class);
    }

    public function getProduct($productId): ProductResource
    {
        $response = $this->get("products/{$productId}.json");

        return new ProductResource($response['product'], $this);
    }

    public function updateProduct($productId, $data): ProductResource
    {
        $response = $this->put("products/{$productId}.json", ['product' => $data]);

        return new ProductResource($response['product'], $this);
    }

    public function deleteProduct($productId): void
    {
        $this->delete("products/{$productId}.json");
    }

    public function createVariant($productId, array $data): VariantResource
    {
        $response = $this->post("products/{$productId}/variants.json", ['variant' => $data]);

        return new VariantResource($response['variant'], $this);
    }

    public function getVariantsCount($productId, array $params = []): int
    {
        $response = $this->get("products/{$productId}/variants/count.json", $params);

        return $response['count'] ?? 0;
    }

    public function paginateVariants($productId, array $params = []): Cursor
    {
        return $this->cursor($this->getVariants($productId, $params));
    }

    public function getVariants($productId, array $params = []): Collection
    {
        $response = $this->get("products/{$productId}/variants.json", $params);

        return $this->transformCollection($response['variants'], VariantResource::class);
    }

    public function getVariant($variantId): VariantResource
    {
        $response = $this->get("variants/{$variantId}.json");

        return new VariantResource($response['variant'], $this);
    }

    public function updateVariant($variantId, array $data): VariantResource
    {
        $response = $this->put("variants/{$variantId}.json", ['variant' => $data]);

        return new VariantResource($response['variant'], $this);
    }

    public function deleteVariant($productId, $variantId): void
    {
        $this->delete("products/{$productId}/variants/{$variantId}.json");
    }

    public function createProductImage($productId, array $data): ProductImageResource
    {
        $response = $this->post("products/{$productId}/images.json", ['image' => $data]);

        return new ProductImageResource($response['image'], $this);
    }

    public function getProductImagesCount($productId, array $params = []): int
    {
        $response = $this->get("products/{$productId}/images/count.json", $params);

        return $response['count'] ?? 0;
    }

    public function paginateProductImages($productId, array $params = []): Cursor
    {
        return $this->cursor($this->getProductImages($productId, $params));
    }

    public function getProductImages($productId, array $params = []): Collection
    {
        $response = $this->get("products/{$productId}/images.json", $params);

        return $this->transformCollection($response['images'], ProductImageResource::class);
    }

    public function getProductImage($productId, $imageId): ProductImageResource
    {
        $response = $this->get("products/{$productId}/images/{$imageId}.json");

        return new ProductImageResource($response['image'], $this);
    }

    public function updateProductImage($productId, $imageId, array $data): ProductImageResource
    {
        $response = $this->put("products/{$productId}/images/{$imageId}.json", ['variant' => $data]);

        return new ProductImageResource($response['image'], $this);
    }

    public function deleteProductImage($productId, $imageId): void
    {
        $this->delete("products/{$productId}/images/{$imageId}.json");
    }
}
