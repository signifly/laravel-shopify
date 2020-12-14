<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\ProductResource;

class ProductAction extends CrudAction
{
    protected string $resourceClass = ProductResource::class;
}
