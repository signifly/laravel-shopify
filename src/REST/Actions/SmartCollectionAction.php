<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\SmartCollectionResource;

class SmartCollectionAction extends CrudAction
{
    protected string $resourceClass = SmartCollectionResource::class;
}
