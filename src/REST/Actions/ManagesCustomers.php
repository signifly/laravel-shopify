<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Cursor;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\REST\Resources\CustomerResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesCustomers
{
    public function createCustomer(array $data): CustomerResource
    {
        return $this->createResource('customers', $data);
    }

    public function getCustomersCount(array $params = []): int
    {
        return $this->getResourceCount('customers', $params);
    }

    public function paginateSearchCustomers(string $query, array $params = []): Cursor
    {
        return $this->cursor($this->searchCustomers($query, $params));
    }

    public function searchCustomers(string $query, array $params = []): Collection
    {
        $response = $this->get('customers/search.json', ['query' => $query] + $params);

        return $this->transformCollection($response['customers'], CustomerResource::class);
    }

    public function paginateCustomers(array $params = []): Cursor
    {
        return $this->cursor($this->getCustomers($params));
    }

    public function getCustomers(array $params = []): Collection
    {
        return $this->getResources('customers', $params);
    }

    public function getCustomer($customerId): CustomerResource
    {
        return $this->getResource('customers', $customerId);
    }

    public function updateCustomer($customerId, $data): CustomerResource
    {
        return $this->updateResource('customers', $customerId, $data);
    }

    public function deleteCustomer($customerId): void
    {
        $this->deleteResource('customers', $customerId);
    }

    public function createCustomerAccountActivationUrl($customerId): string
    {
        return $this->post("customers/{$customerId}/account_activation_url.json")['account_activation_url'];
    }

    public function sendCustomerInvite($customerId, array $data = []): ApiResource
    {
        $response = $this->post("customers/{$customerId}/send_invite.json", ['customer_invite' => $data]);

        return new ApiResource($response['customer_invite'], $this);
    }

    public function paginateCustomerOrders($customerId, array $params = []): Cursor
    {
        return $this->cursor($this->getCustomerOrders($customerId, $params));
    }

    public function getCustomerOrders($customerId, array $params = []): Collection
    {
        return $this->getResources('orders', $params, ['customers', $customerId]);
    }

    public function createCustomerAddress($customerId, array $data): ApiResource
    {
        return $this->createResource('addresses', $data, ['customers', $customerId]);
    }

    public function getCustomerAddresses($customerId, array $params = []): Collection
    {
        return $this->getResources('addresses', $params, ['customers', $customerId]);
    }

    public function getCustomerAddress($customerId, $addressId): ApiResource
    {
        return $this->getResource('addresses', $addressId, ['customers', $customerId]);
    }

    public function updateCustomerAddress($customerId, $addressId, $data): ApiResource
    {
        return $this->updateResource('addresses', $addressId, $data, ['customers', $customerId]);
    }

    public function deleteCustomerAddress($customerId, $addressId): void
    {
        $this->deleteResource('addresses', $addressId, ['customers', $customerId]);
    }

    public function setDefaultCustomerAddress($customerId, $addressId): ApiResource
    {
        $response = $this->put("customers/{$customerId}/addresses/{$addressId}/default.json");

        return new ApiResource($response['customer_address'], $this);
    }
}
