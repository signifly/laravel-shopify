<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Resources\BalanceResource;
use Signifly\Shopify\REST\Resources\DisputeResource;
use Signifly\Shopify\REST\Resources\TransactionResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesShopifyPayments
{
    public function getBalance(): BalanceResource
    {
        $response = $this->get('shopify_payments/balance');

        return new BalanceResource($response['balance'], $this);
    }

    public function getDisputes(array $params = []): Collection
    {
        return $this->getResources('disputes', $params, ['shopify_payments']);
    }

    public function getDispute($disputeId): DisputeResource
    {
        return $this->getResource('disputes', $disputeId, ['shopify_payments']);
    }

    public function createTransaction($orderId, array $data = [])
    {
        return $this->getResources('transactions', $data, ['orders', $orderId]);
    }

    public function getTransactions($orderId, array $params = []): Collection
    {
        return $this->getResources('transactions', $params, ['orders', $orderId]);
    }

    public function getTransaction($orderId): TransactionResource
    {
        return $this->getResource('transactions', ['orders', $orderId]);
    }

    public function getTransactionsCount(array $params = []): int
    {
        return $this->getResourceCount('transactions', $params);
    }

}
