<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\VariantResource;

class VariantAction extends CrudAction
{
    protected string $resourceClass = VariantResource::class;
}
