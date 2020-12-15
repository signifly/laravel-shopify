<?php

namespace Signifly\Shopify\REST\Resources;

use Signifly\Shopify\REST\Actions\TransactionAction;

class OrderResource extends ApiResource
{
    public function delete(): void
    {
        $this->shopify->orders()->destroy($this->id);
    }

    public function update(array $data): ApiResource
    {
        return $this->shopify->orders()->update($this->id, $data);
    }

    public function cancel(): ApiResource
    {
        return $this->shopify->orders()->cancel($this->id);
    }

    public function close(): ApiResource
    {
        return $this->shopify->orders()->close($this->id);
    }

    public function open(): ApiResource
    {
        return $this->shopify->orders()->open($this->id);
    }

    public function fulfillments()
    {
        return $this->shopify->orderFulfillments($this->id);
    }

    public function transactions(): TransactionAction
    {
        return $this->shopify->orderTransactions($this->id);
    }
}
