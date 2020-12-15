<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\ApiResource;

class RefundAction extends CrudAction
{
    protected string $resourceClass = ApiResource::class;
}
