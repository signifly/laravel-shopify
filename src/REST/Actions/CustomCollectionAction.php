<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\CustomCollectionResource;

class CustomCollectionAction extends CrudAction
{
    protected string $resourceClass = CustomCollectionResource::class;
}
