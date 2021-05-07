<?php

namespace Signifly\Shopify\REST\Resources;

use Illuminate\Support\Collection;

class CustomerResource extends ApiResource
{
    public function update(array $data): self
    {
        return $this->shopify->updateCustomer($this->id, $data);
    }

    public function delete(): void
    {
        $this->shopify->deleteCustomer($this->id);
    }

    public function getAddresses(array $params = []): Collection
    {
        return $this->shopify->getCustomerAddresses($this->id, $params);
    }
}
