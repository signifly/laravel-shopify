<?php

namespace Signifly\Shopify\REST\Resources;

use Illuminate\Support\Collection;

class OrderResource extends ApiResource
{
    public function update(array $data): ApiResource
    {
        return $this->shopify->updateOrder($this->id, $data);
    }

    public function delete(): void
    {
        $this->shopify->deleteOrder($this->id);
    }

    public function cancel(): ApiResource
    {
        return $this->shopify->cancelOrder($this->id);
    }

    public function close(): ApiResource
    {
        return $this->shopify->closeOrder($this->id);
    }

    public function open(): ApiResource
    {
        return $this->shopify->openOrder($this->id);
    }

    public function getFulfillments(array $params = []): Collection
    {
        return $this->shopify->getOrderFulfillments($this->id, $params);
    }

    public function getRefunds(array $params = []): Collection
    {
        return $this->shopify->getOrderRefunds($this->id, $params);
    }

    public function getRisks(array $params = []): Collection
    {
        return $this->shopify->getOrderRisks($this->id, $params);
    }

    public function getTransactions(array $params = []): Collection
    {
        return $this->shopify->getOrderTransactions($this->id, $params);
    }
}
