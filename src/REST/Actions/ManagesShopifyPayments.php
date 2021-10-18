<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Resources\BalanceResource;
use Signifly\Shopify\REST\Resources\DisputeResource;
use Signifly\Shopify\REST\Resources\TransactionResource;
use Signifly\Shopify\REST\Resources\PayoutResource;
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

    public function getPayouts(array $params = []): Collection
    {
        return $this->getResources('payouts', $params, ['shopify_payments']);
    }

    public function getPayout($payoutId): PayoutResource
    {
        return $this->getResource('payouts', $payoutId, ['shopify_payments']);
    }

    public function createTransaction($orderId, array $data = [])
    {
        return $this->createResource('transactions', $data, ['shopify_payments', 'orders', $orderId]);
    }

    public function getTransactions($orderId, array $params = []): Collection
    {
        return $this->getResources('transactions', $params, ['shopify_payments', 'orders', $orderId]);
    }

    public function getTransaction($transactionId, $orderId): TransactionResource
    {
        return $this->getResource('transactions', $transactionId, ['shopify_payments', 'orders', $orderId]);
    }

    public function getTransactionsCount($orderId, array $params = []): int
    {
        return $this->getResourceCount('transactions', $params, ['shopify_payments', 'orders', $orderId]);
    }
}
