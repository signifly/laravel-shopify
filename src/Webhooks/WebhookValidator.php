<?php

namespace Signifly\Shopify\Webhooks;

use Illuminate\Http\Request;
use Signifly\Shopify\Exceptions\WebhookFailed;
use Signifly\Shopify\Support\VerifiesWebhooks;

class WebhookValidator
{
    use VerifiesWebhooks;

    private SecretProvider $secretProvider;

    public function __construct(SecretProvider $secretProvider)
    {
        $this->secretProvider = $secretProvider;
    }

    public function validate(string $signature, string $domain, string $data): void
    {
        // Validate webhook secret presence
        $secret = $this->secretProvider->getSecret($domain);
        throw_if(empty($secret), WebhookFailed::missingSigningSecret());

        // Validate webhook signature
        throw_unless(
            $this->isWebhookSignatureValid($signature, $data, $secret),
            WebhookFailed::invalidSignature($signature)
        );
    }

    public function validateFromRequest(Request $request): void
    {
        // Validate signature presence
        $signature = $request->shopifyHmacSignature();
        throw_unless($signature, WebhookFailed::missingSignature());

        // Validate topic presence
        throw_unless($request->shopifyTopic(), WebhookFailed::missingTopic());

        $this->validate($signature, $request->shopifyShopDomain(), $request->getContent());
    }
}
