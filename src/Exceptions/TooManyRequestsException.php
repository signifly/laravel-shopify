<?php

namespace Signifly\Shopify\Exceptions;

use Illuminate\Http\Client\Response;

class TooManyRequestsException extends \Exception
{
    public Response $response;

    public function __construct(Response $response, $message = null)
    {
        $this->response = $response;

        parent::__construct($message ?? 'Too many requests.');
    }
}
