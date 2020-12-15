<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Resources\ApiResource;

abstract class CrudAction extends Action
{
    public function all(array $params = []): Collection
    {
        $response = $this->shopify->get($this->path());

        return $this->transformCollectionFromResponse($response);
    }

    public function get(array $params = []): Collection
    {
        return $this->all($params);
    }

    public function create(array $data): ApiResource
    {
        $response = $this->shopify->post($this->path(), [
            $this->resourceKey->singular() => $data,
        ]);

        return $this->transformItemFromResponse($response);
    }

    public function update($id, array $data): ApiResource
    {
        $response = $this->shopify->put($this->path($id), [
            $this->resourceKey->singular() => $data,
        ]);

        return $this->transformItemFromResponse($response);
    }

    public function find($id): ApiResource
    {
        $response = $this->shopify->get($this->path($id));

        return $this->transformItemFromResponse($response);
    }

    public function destroy($id): void
    {
        $this->shopify->delete($this->path($id));
    }

    public function delete($id): void
    {
        $this->destroy($id);
    }

    public function count(array $params = []): int
    {
        $response = $this->shopify->get(
            $this->path()->appends('count')->withParams($params)
        );

        return $response->json('count') ?? 0;
    }
}
