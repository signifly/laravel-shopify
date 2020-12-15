<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\ApiResource;

class FulfillmentAction extends CrudAction
{
    public function updateTracking($id, array $data): ApiResource
    {
        if ($this->hasParent()) {
            throw new \RuntimeException('Can only be called without a parent resource.');
        }

        $response = $this->shopify->post(
            $this->path($id)->appends('update_tracking'),
            $this->preparePayload($data)
        );

        return $this->transformItemFromResponse($response);
    }

    public function cancel($id): ApiResource
    {
        $response = $this->shopify->post($this->path($id)->appends('cancel'));

        return $this->transformItemFromResponse($response);
    }

    public function complete($id): ApiResource
    {
        $response = $this->shopify->post($this->path($id)->appends('complete'));

        return $this->transformItemFromResponse($response);
    }

    public function open($id): ApiResource
    {
        $response = $this->shopify->post($this->path($id)->appends('open'));

        return $this->transformItemFromResponse($response);
    }
}
