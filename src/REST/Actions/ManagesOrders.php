<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Cursor;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\REST\Resources\DraftOrderResource;
use Signifly\Shopify\REST\Resources\OrderResource;
use Signifly\Shopify\REST\Resources\RefundResource;
use Signifly\Shopify\REST\Resources\RiskResource;
use Signifly\Shopify\REST\Resources\TransactionResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesOrders
{
    public function createOrder(array $data): OrderResource
    {
        return $this->createResource('orders', $data);
    }

    public function getOrdersCount(array $params = []): int
    {
        return $this->getResourceCount('orders', $params);
    }

    public function paginateOrders(array $params = []): Cursor
    {
        return $this->cursor($this->getOrders($params));
    }

    public function getOrders(array $params = []): Collection
    {
        return $this->getResources('orders', $params);
    }

    public function getOrder($orderId): OrderResource
    {
        return $this->getResource('orders', $orderId);
    }

    public function updateOrder($orderId, $data): OrderResource
    {
        return $this->updateResource('orders', $orderId, $data);
    }

    public function deleteOrder($orderId): void
    {
        $this->deleteResource('orders', $orderId);
    }

    public function closeOrder($orderId): OrderResource
    {
        $response = $this->post("orders/{$orderId}/close.json");

        return new OrderResource($response['order'], $this);
    }

    public function openOrder($orderId): OrderResource
    {
        $response = $this->get("orders/{$orderId}/open.json");

        return new OrderResource($response['order'], $this);
    }

    public function cancelOrder($orderId): OrderResource
    {
        $response = $this->post("orders/{$orderId}/cancel.json");

        return new OrderResource($response['order'], $this);
    }

    public function createOrderRisk($orderId, array $data): RiskResource
    {
        return $this->createResource('risks', $data, ['orders', $orderId]);
    }

    public function getOrderRisks($orderId, array $params = []): Collection
    {
        return $this->getResources('risks', $params, ['orders', $orderId]);
    }

    public function getOrderRisk($orderId, $riskId): Collection
    {
        return $this->getResource('risks', $riskId, ['orders', $orderId]);
    }

    public function updateOrderRisk($orderId, $riskId, array $data): RiskResource
    {
        return $this->updateResource('risks', $riskId, $data, ['orders', $orderId]);
    }

    public function deleteOrderRisk($orderId, $riskId): void
    {
        $this->deleteResource('risks', $riskId, ['orders', $orderId]);
    }

    public function createOrderRefund($orderId, array $data): RefundResource
    {
        return $this->createResource('refunds', $data, ['orders', $orderId]);
    }

    public function getOrderRefunds($orderId, array $params = []): Collection
    {
        return $this->getResources('refunds', $params, ['orders', $orderId]);
    }

    public function getOrderRefund($orderId, $refundId): RefundResource
    {
        return $this->getResource('refunds', $refundId, ['orders', $orderId]);
    }

    public function calculateOrderRefund($orderId, array $data): RefundResource
    {
        $response = $this->post("orders/{$orderId}/refunds/calculate.json", ['refund' => $data]);

        return new RefundResource($response['refund'], $this);
    }

    public function getOrderTransactionsCount($orderId, array $params = []): Collection
    {
        return $this->getResourceCount('transactions', $params, ['orders', $orderId]);
    }

    public function getOrderTransactions($orderId, array $params = []): Collection
    {
        return $this->getResources('transactions', $params, ['orders', $orderId]);
    }

    public function createOrderTransaction($orderId, array $data): TransactionResource
    {
        return $this->createResource('transactions', $data, ['orders', $orderId]);
    }

    public function createDraftOrder(array $data): DraftOrderResource
    {
        return $this->createResource('draft_orders', $data);
    }

    public function getDraftOrdersCount(array $params = []): int
    {
        return $this->getResourceCount('draft_orders', $params);
    }

    public function paginateDraftOrders(array $params = []): Cursor
    {
        return $this->cursor($this->getDraftOrders($params));
    }

    public function getDraftOrders(array $params = []): Collection
    {
        return $this->getResources('draft_orders', $params);
    }

    public function getDraftOrder($orderId): DraftOrderResource
    {
        return $this->getResource('draft_orders', $orderId);
    }

    public function updateDraftOrder($orderId, $data): DraftOrderResource
    {
        return $this->updateResource('draft_orders', $orderId, $data);
    }

    public function deleteDraftOrder($orderId): void
    {
        $this->deleteResource('draft_orders', $orderId);
    }

    public function sendDraftOrderInvoice($orderId, array $data): ApiResource
    {
        $response = $this->post("draft_orders/{$orderId}/send_invoice.json", ['draft_order_invoice' => $data]);

        return new ApiResource($response['draft_order_invoice'], $this);
    }

    public function completeDraftOrder($orderId, bool $paymentPending = false): DraftOrderResource
    {
        $response = $this->put("draft_orders/{$orderId}/complete.json", ['payment_pending' => $paymentPending]);

        return new DraftOrderResource($response['draft_order'], $this);
    }

    public function getCheckoutsCount(array $params = []): int
    {
        return $this->getResourceCount('checkouts', $params);
    }

    public function getCheckouts(array $params = []): Collection
    {
        return $this->getResources('checkouts', $params);
    }
}
