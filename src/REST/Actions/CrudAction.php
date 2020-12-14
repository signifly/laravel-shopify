<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Resources\ApiResource;

abstract class CrudAction extends Action
{
    public function all(array $params = []): Collection
    {
        $response = $this->shopify->get($this->resourceKey->plural().'.json');

        return $this->transformCollectionFromResponse($response);
    }

    public function get(array $params = []): Collection
    {
        return $this->all($params);
    }

    public function create(array $data): ApiResource
    {
        $response = $this->shopify->post($this->resourceKey->plural().'.json', [
            $this->resourceKey->singular() => $data,
        ]);

        return $this->transformItemFromResponse($response);
    }

    public function update($id, array $data): ApiResource
    {
        $response = $this->shopify->put($this->resourceKey->plural().'/'.$id.'.json', [
            $this->resourceKey->singular() => $data,
        ]);

        return $this->transformItemFromResponse($response);
    }

    public function find($id): ApiResource
    {
        $response = $this->shopify->get($this->resourceKey->plural().'/'.$id.'.json');

        return $this->transformItemFromResponse($response);
    }

    public function destroy($id): void
    {
        $this->shopify->delete($this->resourceKey->plural().'/'.$id.'.json');
    }

    public function delete($id): void
    {
        $this->destroy($id);
    }
}
