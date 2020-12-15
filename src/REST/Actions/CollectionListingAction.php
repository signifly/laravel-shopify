<?php

namespace Signifly\Shopify\REST\Actions;

class CollectionListingAction extends CrudAction
{
    public function productIds(): array
    {
        $response = $this->shopify->get(
            $this->path()->appends('product_ids')
        );

        return $response->json('product_ids');
    }
}
