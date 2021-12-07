<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesFulfillments
{
    public function getOrderFulfillmentsCount($orderId, array $params = []): int
    {
        return $this->getResourceCount('fulfillments', $params, ['orders', $orderId]);
    }

    public function getOrderFulfillments($orderId, array $params = []): Collection
    {
        return $this->getResources('fulfillments', $params, ['orders', $orderId]);
    }

    public function getOrderFulfillment($orderId, $fulfillmentId): ApiResource
    {
        return $this->getResource('fulfillments', $fulfillmentId, ['orders', $orderId]);
    }

    public function createOrderFulfillment($orderId, array $data): ApiResource
    {
        return $this->createResource('fulfillments', $data, ['orders', $orderId]);
    }

    public function createFulfillment(array $data): ApiResource
    {
        return $this->createResource('fulfillments', $data);
    }

    public function updateOrderFulfillment($orderId, $fulfillmentId, array $data): ApiResource
    {
        return $this->updateResource('fulfillments', $fulfillmentId, $data, ['orders', $orderId]);
    }

    public function updateTrackingForFulfillment($fulfillmentId, array $data): ApiResource
    {
        $response = $this->post("fulfillments/{$fulfillmentId}/update_tracking.json", $data);

        return new ApiResource($response['fulfillment'], $this);
    }

    public function completeOrderFulfillment($orderId, $fulfillmentId): ApiResource
    {
        $response = $this->post("orders/{$orderId}/fulfillments/{$fulfillmentId}/complete.json");

        return new ApiResource($response['fulfillment'], $this);
    }

    public function openOrderFulfillment($orderId, $fulfillmentId): ApiResource
    {
        $response = $this->post("orders/{$orderId}/fulfillments/{$fulfillmentId}/open.json");

        return new ApiResource($response['fulfillment'], $this);
    }

    public function cancelOrderFulfillment($orderId, $fulfillmentId): ApiResource
    {
        $response = $this->post("orders/{$orderId}/fulfillments/{$fulfillmentId}/cancel.json");

        return new ApiResource($response['fulfillment'], $this);
    }

    public function cancelFulfillment($fulfillmentId): ApiResource
    {
        $response = $this->post("fulfillments/{$fulfillmentId}/cancel.json");

        return new ApiResource($response['fulfillment'], $this);
    }

    public function getFulfillmentOrderFulfillments($fulfillmentOrderId, array $params = []): Collection
    {
        return $this->getResources('fulfillments', $params, ['fulfillment_orders', $fulfillmentOrderId]);
    }

    public function getOrderFulfillmentEvents($orderId, $fulfillmentId, array $params = []): Collection
    {
        return $this->getResources('events', $params, ['orders', $orderId, 'fulfillments', $fulfillmentId]);
    }

    public function getOrderFulfillmentEvent($orderId, $fulfillmentId, $eventId): ApiResource
    {
        return $this->getResource('events', $eventId, ['orders', $orderId, 'fulfillments', $fulfillmentId]);
    }

    public function createOrderFulfillmentEvent($orderId, $fulfillmentId, array $data): ApiResource
    {
        return $this->createResource('events', $data, ['orders', $orderId, 'fulfillments', $fulfillmentId]);
    }

    public function deleteOrderFulfillmentEvent($orderId, $fulfillmentId, $eventId): void
    {
        $this->deleteResource('events', $eventId, ['orders', $orderId, 'fulfillments', $fulfillmentId]);
    }

    public function getOrderFulfillmentOrders($orderId, array $params = []): Collection
    {
        return $this->getResources('fulfillment_orders', $params, ['orders', $orderId]);
    }

    public function getFulfillmentOrder($fulfillmentOrderId): ApiResource
    {
        return $this->getResource('fulfillment_orders', $fulfillmentOrderId);
    }

    public function cancelFulfillmentOrder($fulfillmentOrderId): ApiResource
    {
        $response = $this->post("fulfillment_orders/{$fulfillmentOrderId}/cancel.json");

        return new ApiResource($response['fulfillment_order'], $this);
    }

    public function closeFulfillmentOrder($fulfillmentOrderId, array $data): ApiResource
    {
        $response = $this->post("fulfillment_orders/{$fulfillmentOrderId}/close.json", [
            'fulfillment_order' => $data,
        ]);

        return new ApiResource($response['fulfillment_order'], $this);
    }

    public function moveFulfillmentOrder($fulfillmentOrderId, array $data): ApiResource
    {
        $response = $this->post("fulfillment_orders/{$fulfillmentOrderId}/close.json", [
            'fulfillment_order' => $data,
        ]);

        return new ApiResource($response['fulfillment_order'], $this);
    }

    public function getFulfillmentOrderLocationsForMove($fulfillmentOrderId, array $params = []): Collection
    {
        return $this->getResources('locations_for_move', $params, ['fulfillment_orders', $fulfillmentOrderId]);
    }

    public function sendFulfillmentOrderFulfillmentRequest($fulfillmentOrderId, array $data = []): ApiResource
    {
        $response = $this->post("fulfillment_orders/{$fulfillmentOrderId}/fulfillment_request.json", [
            'fulfillment_request' => $data,
        ]);

        return new ApiResource($response['original_fulfillment_order'], $this);
    }

    public function acceptFulfillmentOrderFulfillmentRequest($fulfillmentOrderId, array $data = []): ApiResource
    {
        $response = $this->post("fulfillment_orders/{$fulfillmentOrderId}/fulfillment_request/accept.json", [
            'fulfillment_request' => $data,
        ]);

        return new ApiResource($response['fulfillment_order'], $this);
    }

    public function rejectFulfillmentOrderFulfillmentRequest($fulfillmentOrderId, array $data = []): ApiResource
    {
        $response = $this->post("fulfillment_orders/{$fulfillmentOrderId}/fulfillment_request/reject.json", [
            'fulfillment_request' => $data,
        ]);

        return new ApiResource($response['fulfillment_order'], $this);
    }

    public function createFulfillmentService(array $data): ApiResource
    {
        return $this->createResource('fulfillment_services', $data);
    }

    public function getFulfillmentServices(array $params = []): Collection
    {
        return $this->getResources('fulfillment_services', $params);
    }

    public function getFulfillmentService($fulfillmentServiceId): ApiResource
    {
        return $this->getResource('fulfillment_services', $fulfillmentServiceId);
    }

    public function updateFulfillmentService($fulfillmentServiceId, array $data): ApiResource
    {
        return $this->updateResource('fulfillment_services', $fulfillmentServiceId, $data);
    }

    public function deleteFulfillmentService($fulfillmentServiceId): void
    {
        $this->deleteResource('fulfillment_services', $fulfillmentServiceId);
    }

    public function createCarrierService(array $data): ApiResource
    {
        return $this->createResource('carrier_services', $data);
    }

    public function getCarrierServices(array $params = []): Collection
    {
        return $this->getResources('carrier_services', $params);
    }

    public function getCarrierService($carrierServiceId): ApiResource
    {
        return $this->getResource('carrier_services', $carrierServiceId);
    }

    public function updateCarrierService($carrierServiceId, array $data): ApiResource
    {
        return $this->updateResource('carrier_services', $carrierServiceId, $data);
    }

    public function deleteCarrierService($carrierServiceId): void
    {
        $this->deleteResource('carrier_services', $carrierServiceId);
    }

    public function sendFulfillmentOrderCancellationRequest($fulfillmentOrderId, array $data = []): ApiResource
    {
        $response = $this->post("fulfillment_orders/{$fulfillmentOrderId}/cancellation_request.json", [
            'cancellation_request' => $data,
        ]);

        return new ApiResource($response['fulfillment_order'], $this);
    }

    public function acceptFulfillmentOrderCancellationRequest($fulfillmentOrderId, array $data = []): ApiResource
    {
        $response = $this->post("fulfillment_orders/{$fulfillmentOrderId}/cancellation_request/accept.json", [
            'cancellation_request' => $data,
        ]);

        return new ApiResource($response['fulfillment_order'], $this);
    }

    public function rejectFulfillmentOrderCancellationRequest($fulfillmentOrderId, array $data = []): ApiResource
    {
        $response = $this->post("fulfillment_orders/{$fulfillmentOrderId}/cancellation_request/reject.json", [
            'cancellation_request' => $data,
        ]);

        return new ApiResource($response['fulfillment_order'], $this);
    }

    public function getAssignedFulfillmentOrders(string $assignmentStatus, array $locationIds): Collection
    {
        $response = $this->get('assigned_fulfillment_orders.json', [
            'assignment_status' => $assignmentStatus,
            'location_ids%5B%5D' => $locationIds,
        ]);

        return $this->transformCollection($response['fulfillment_orders'], ApiResource::class);
    }
}
