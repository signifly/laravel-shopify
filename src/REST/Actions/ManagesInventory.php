<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesInventory
{
    public function getInventoryItems(array $params = []): Collection
    {
        $response = $this->get('inventory_items.json', $params);

        return $this->transformCollection($response['inventory_items'], ApiResource::class);
    }

    public function getInventoryItem($inventoryItemId): ApiResource
    {
        $response = $this->get("inventory_items/{$inventoryItemId}.json");

        return new ApiResource($response['inventory_item'], $this);
    }

    public function updateInventoryItem($inventoryItemId, array $data): ApiResource
    {
        $response = $this->put("inventory_items/{$inventoryItemId}.json", ['inventory_item' => $data]);

        return new ApiResource($response['inventory_item'], $this);
    }

    public function getInventoryLevels(array $params = []): Collection
    {
        $response = $this->get('inventory_levels.json', $params);

        return $this->transformCollection($response['inventory_levels'], ApiResource::class);
    }

    public function deleteInventoryLevel($inventoryItemId, $locationId): void
    {
        $this->delete('inventory_levels.json', [
            'inventory_item_id' => $inventoryItemId,
            'location_id' => $locationId,
        ]);
    }

    public function adjustInventoryLevel($inventoryItemId, $locationId, int $availableAdjustment): ApiResource
    {
        $response = $this->post('inventory_levels/adjust.json', [
            'inventory_item_id' => $inventoryItemId,
            'location_id' => $locationId,
            'available_adjustment' => $availableAdjustment,
        ]);

        return new ApiResource($response['inventory_level'], $this);
    }

    public function connectInventoryLevel($inventoryItemId, $locationId, bool $relocate = false): ApiResource
    {
        $response = $this->post('inventory_levels/connect.json', [
            'inventory_item_id' => $inventoryItemId,
            'location_id' => $locationId,
            'relocate_if_necessary' => $relocate,
        ]);

        return new ApiResource($response['inventory_level'], $this);
    }

    public function setInventoryLevel($inventoryItemId, $locationId, int $available, bool $disconnect = false): ApiResource
    {
        $response = $this->post('inventory_levels/set.json', [
            'inventory_item_id' => $inventoryItemId,
            'location_id' => $locationId,
            'available' => $available,
            'disconnect_if_necessary' => $disconnect,
        ]);

        return new ApiResource($response['inventory_level'], $this);
    }

    public function getLocationsCount(array $params = []): int
    {
        $response = $this->get('locations/count.json', $params);

        return $response['count'] ?? 0;
    }

    public function getLocations(array $params = []): Collection
    {
        $response = $this->get('locations.json', $params);

        return $this->transformCollection($response['locations'], ApiResource::class);
    }

    public function getLocation($locationId): ApiResource
    {
        $response = $this->get("locations/{$locationId}.json");

        return $this->transformItem($response['location'], ApiResource::class);
    }

    public function getLocationInventoryLevels($locationId, array $params = []): Collection
    {
        $response = $this->get("locations/{$locationId}/inventory_levels.json", $params);

        return $this->transformCollection($response['inventory_levels'], ApiResource::class);
    }
}
