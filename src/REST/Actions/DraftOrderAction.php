<?php

namespace Signifly\Shopify\REST\Actions;

use Signifly\Shopify\REST\Resources\ApiResource;

class DraftOrderAction extends CrudAction
{
    protected string $resourceClass = ApiResource::class;

    public function complete($id): ApiResource
    {
        $response = $this->shopify->put($this->path($id)->appends('complete'));

        return $this->transformItemFromResponse($response);
    }

    public function sendInvoice($id): ApiResource
    {
        $response = $this->shopify->post($this->path($id)->appends('send_invoice'));

        return $this->transformItemFromResponse($response);
    }
}
