<?php

namespace Signifly\Shopify\Laravel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Signifly\Shopify\Laravel\Webhooks\Webhook;
use Signifly\Shopify\Laravel\Http\Middleware\ValidateWebhook;

class WebhookController extends Controller
{
    public function __construct()
    {
        $this->middleware(ValidateWebhook::class);
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
            Event::dispatch(
                $this->getEventName($this->buildWebhook($request)),
                $this->buildWebhook($request)
            );

            return response()->json();
        } catch (Exception $e) {
            return response('Error handling webhook', 500);
        }
    }

    protected function buildWebhook(Request $request)
    {
        return new Webhook(
            $request->shopifyShopDomain(),
            $request->shopifyTopic(),
            json_decode($request->getContent(), true)
        );
    }

    protected function getEventName(Webhook $webhook)
    {
        return 'laravel-shopify-webhook.'.str_replace('/', '-', $webhook->topic());
    }
}
