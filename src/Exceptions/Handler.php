<?php

namespace Signifly\Shopify\Exceptions;

use Illuminate\Support\Arr;
use Illuminate\Http\Client\Response;

class Handler implements ErrorHandlerInterface
{
    public function handle(Response $response)
    {
        if ($response->successful()) {
            return;
        }

        if ($response->status() === 429) {
            throw new TooManyRequestsException($response);
        }

        if ($response->status() === 422) {
            throw new ValidationException(Arr::wrap($response->json('errors', [])));
        }

        if ($response->status() === 404) {
            throw new NotFoundException();
        }

        $response->throw();
    }
}
