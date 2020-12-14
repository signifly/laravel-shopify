<?php

namespace Signifly\Shopify\Support;

trait VerifiesWebhooks
{
    public function isWebhookSignatureValid(string $signature, string $data, string $secret): bool
    {
        return hash_equals($signature, $this->calculateSignature($data, $secret));
    }

    public function calculateSignature(string $data, string $secret): string
    {
        return base64_encode(hash_hmac('sha256', $data, $secret, true));
    }
}
