<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\ApiResource;

class ProductListingAction extends CrudAction
{
    protected string $resourceClass = ApiResource::class;

    public function productIds(): array
    {
        $response = $this->shopify->get(
            $this->path()->appends('product_ids')
        );

        return $response->json('product_ids');
    }
}
