<?php

namespace Signifly\Shopify\Support;

use Illuminate\Http\Client\Response;
use Signifly\Shopify\Exceptions\Handler;
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

    public function delete(string $url, array $data = [])
    {
        $response = $this->getHttpClient()->delete($url, $data);

        $this->handleErrorResponse($response);

        return $response;
    }

    public function getLastResponse(): Response
    {
        return $this->lastResponse;
    }

    private function handleErrorResponse(Response $response): void
    {
        $this->lastResponse = $response;

        app(Handler::class)->handle($response);
    }
}
