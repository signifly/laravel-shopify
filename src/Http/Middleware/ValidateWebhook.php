<?php

namespace Signifly\Shopify\Laravel\Http\Middleware;

use Closure;
use Facades\Signifly\Shopify\Shopify;
use Signifly\Shopify\Laravel\Exceptions\WebhookFailed;

class ValidateWebhook
{
    public function handle($request, Closure $next)
    {
        $signature = $request->shopifyHmacSha256();

        if (! $signature) {
            throw WebhookFailed::missingSignature();
        }

        $secret = $this->getSecretProvider()->getSecret($request->shopifyShopDomain());

        if (empty($secret)) {
            throw WebhookFailed::signingSecretNotSet();
        }

        if (! Shopify::verifyWebhook($signature, $request->getContent(), $secret)) {
            throw WebhookFailed::invalidSignature($signature);
        }

        if (! $request->shopifyTopic()) {
            throw WebhookFailed::missingTopic($request);
        }

        return $next($request);
    }

    protected function getSecretProvider()
    {
        $secretProviderClass = config('shopify.webhook_secret_provider');

        return new $secretProviderClass();
    }
}
