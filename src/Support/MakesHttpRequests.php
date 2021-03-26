<?php

namespace Signifly\Shopify\Support;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Signifly\Shopify\Exceptions\ErrorHandlerInterface;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\Shopify;

/**
 * @mixin Shopify
 */
trait MakesHttpRequests
{
    protected Response $lastResponse;

    public function get(string $url, $query = null): Response
    {
        $response = $this->getHttpClient()->get($url, $query);

        $this->handleErrorResponse($response);

        return $response;
    }

    public function post(string $url, array $data = []): Response
    {
        $response = $this->getHttpClient()->post($url, $data);

        $this->handleErrorResponse($response);

        return $response;
    }

    public function put(string $url, array $data = []): Response
    {
        $response = $this->getHttpClient()->put($url, $data);

        $this->handleErrorResponse($response);

        return $response;
    }

    public function delete(string $url, array $data = []): Response
    {
        $response = $this->getHttpClient()->delete($url, $data);

        $this->handleErrorResponse($response);

        return $response;
    }

    protected function resourceClassFor(string $resource): string
    {
        $resourceClass = Str::of($resource)
            ->studly()
            ->singular()
            ->prepend('Signifly\\Shopify\\REST\\Resources\\')
            ->append('Resource');

        return class_exists($resourceClass) ? $resourceClass : ApiResource::class;
    }

    protected function createResource(string $resource, array $data, array $uriPrefix = []): ApiResource
    {
        $key = Str::singular($resource);
        $resourceClass = $this->resourceClassFor($resource);

        $response = $this->post(implode('/', [...$uriPrefix, "{$resource}.json"]), [$key => $data]);

        return new $resourceClass($response[$key], $this);
    }

    protected function getResourceCount(string $resource, array $params, array $uriPrefix = []): int
    {
        $response = $this->get(implode('/', [...$uriPrefix, "{$resource}/count.json"]), $params);

        return $response['count'] ?? 0;
    }

    protected function getResources(string $resource, array $params, array $uriPrefix = []): Collection
    {
        $resourceClass = $this->resourceClassFor($resource);
        $response = $this->get(implode('/', [...$uriPrefix, "{$resource}.json"]), $params);

        return $this->transformCollection($response[$resource], $resourceClass);
    }

    protected function getResource(string $resource, $resourceId, array $uriPrefix = []): ApiResource
    {
        $key = Str::singular($resource);
        $resourceClass = $this->resourceClassFor($resource);

        $response = $this->get(implode('/', [...$uriPrefix, "{$resource}/{$resourceId}.json"]));

        return new $resourceClass($response[$key], $this);
    }

    protected function updateResource(string $resource, $resourceId, array $data, array $uriPrefix = []): ApiResource
    {
        $key = Str::singular($resource);
        $resourceClass = $this->resourceClassFor($resource);

        $response = $this->put(implode('/', [...$uriPrefix, "{$resource}/{$resourceId}.json"]), [$key => $data]);

        return new $resourceClass($response[$key], $this);
    }

    protected function deleteResource(string $resource, $resourceId, array $uriPrefix = []): void
    {
        $this->delete(implode('/', [...$uriPrefix, "{$resource}/{$resourceId}.json"]));
    }

    public function getLastResponse(): Response
    {
        return $this->lastResponse;
    }

    private function handleErrorResponse(Response $response): void
    {
        $this->lastResponse = $response;

        app(ErrorHandlerInterface::class)->handle($response);
    }
}
