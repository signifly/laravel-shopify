<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\ApiResource;

class AddressAction extends CrudAction
{
    protected string $resourceClass = ApiResource::class;
}
