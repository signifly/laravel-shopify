<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\ImageResource;

class ImageAction extends CrudAction
{
    protected string $resourceClass = ImageResource::class;
}
