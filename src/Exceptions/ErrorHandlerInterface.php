<?php

namespace Signifly\Shopify\Exceptions;

use Illuminate\Http\Client\Response;

interface ErrorHandlerInterface
{
    public function handle(Response $response);
}
