<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\ApiResource;

class InventoryLevelAction extends CrudAction
{
    public function adjust(array $data): ApiResource
    {
        $response = $this->shopify->post($this->path()->appends('adjust'), $data);

        return $this->transformItemFromResponse($response);
    }

    public function connect(array $data): ApiResource
    {
        $response = $this->shopify->post($this->path()->appends('connect'), $data);

        return $this->transformItemFromResponse($response);
    }

    public function set(array $data): ApiResource
    {
        $response = $this->shopify->post($this->path()->appends('set'), $data);

        return $this->transformItemFromResponse($response);
    }
}
