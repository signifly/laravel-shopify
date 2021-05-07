<?php

namespace Signifly\Shopify\Exceptions;

use Exception;

class WebhookFailed extends Exception
{
    public static function missingSignature()
    {
        return new static('The request did not contain a header named `X-Shopify-Hmac-Sha256`.');
    }

    public static function invalidSignature(string $signature)
    {
        return new static("The signature `{$signature}` found in the header named `X-Shopify-Hmac-Sha256` is invalid.");
    }

    public static function missingSigningSecret()
    {
        return new static('The webhook signing secret is not set.');
    }

    public static function missingTopic()
    {
        return new static('The webhook call did not contain a topic. Valid webhook calls should always contain a topic.');
    }

    /**
     * Render the exception into an HTTP response.
     *
     * NOTE: https://laravel.com/docs/8.x/errors#renderable-exceptions
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response(['error' => $this->getMessage()], 400);
    }
}
