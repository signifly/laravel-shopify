<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\ApiResource;

class CustomerAction extends CrudAction
{
    protected string $resourceClass = ApiResource::class;
}
