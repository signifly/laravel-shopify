<?php

namespace Signifly\Shopify\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Signifly\Shopify\Webhooks\Webhook;
use Signifly\Shopify\Events\WebhookReceived;
use Signifly\Shopify\Exceptions\WebhookFailed;
use Signifly\Shopify\Http\Middleware\VerifySignature;

class WebhookController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifySignature::class);
    }

    /**
     * Handle the incoming webhook.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        try {
            event(new WebhookReceived($this->buildWebhook($request)));

            return response(null, 200);
        } catch (Exception $e) {
            return response('Error handling webhook', 500);
        }
    }

    protected function buildWebhook(Request $request)
    {
        $topic = $request->shopifyTopic();

        if (! $topic)) {
            throw WebhookFailed::missingTopic($request);
        }

        return new Webhook($request->shopifyShopHandle(), $topic, $this->getPayload($request));
    }

    protected function getPayload(Request $request)
    {
        return json_decode($request->getContent(), true);
    }
}
