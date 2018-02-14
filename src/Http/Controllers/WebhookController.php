<?php

namespace Signifly\Shopify\Laravel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Signifly\Shopify\Laravel\Webhooks\Webhook;
use Signifly\Shopify\Laravel\Events\WebhookReceived;
use Signifly\Shopify\Laravel\Exceptions\WebhookFailed;
use Signifly\Shopify\Laravel\Http\Middleware\VerifySignature;

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
            $this->dispatchEvents($this->buildWebhook($request));

            return response()->json();
        } catch (Exception $e) {
            return response('Error handling webhook', 500);
        }
    }

    protected function buildWebhook(Request $request)
    {
        $topic = $request->shopifyTopic();

        if (! $topic) {
            throw WebhookFailed::missingTopic($request);
        }

        return new Webhook($request->shopifyShopDomain(), $topic, json_decode($request->getContent(), true));
    }

    /**
     * Fire a generic event, then a specific event for the given Shopify "topic".
     *
     * @param  Webhook $webhook [description]
     * @return [type]           [description]
     */
    protected function dispatchEvents(Webhook $webhook)
    {
        event(new WebhookReceived($webhook));

        Event::dispatch($this->getEventName($webhook), $webhook);
    }

    protected function getEventName(Webhook $webhook)
    {
        return 'laravel-shopify-webhook:' . str_replace('/', '-', $webhook->topic());
    }
}
