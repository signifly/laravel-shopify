<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\Exceptions\InvalidMethodException;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\REST\Resources\CollectResource;

class CollectAction extends CrudAction
{
    protected string $resourceClass = CollectResource::class;

    public function update($id, array $data): ApiResource
    {
        throw new InvalidMethodException();
    }
}
