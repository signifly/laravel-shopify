<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\REST\Resources\OrderResource;

class OrderAction extends CrudAction
{
    protected string $resourceClass = OrderResource::class;

    public function cancel($id): ApiResource
    {
        $response = $this->shopify->post($this->path($id)->appends('cancel'));

        return $this->transformItemFromResponse($response);
    }

    public function close($id): ApiResource
    {
        $response = $this->shopify->post($this->path($id)->appends('close'));

        return $this->transformItemFromResponse($response);
    }

    public function open($id): ApiResource
    {
        $response = $this->shopify->post($this->path($id)->appends('open'));

        return $this->transformItemFromResponse($response);
    }
}
