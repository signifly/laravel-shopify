<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\ProductImageResource;

class ImageAction extends CrudAction
{
    protected string $resourceClass = ProductImageResource::class;
}
